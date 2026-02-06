<?php

namespace App\Jobs;

use App\Models\Analysis;
use App\Models\HistoryEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AnalyzePhotoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $analysisId) {}

    public function handle(): void
    {
        $analysis = Analysis::with('photo')->findOrFail($this->analysisId);
        $photo = $analysis->photo;

        // running
        $analysis->update([
            'status' => 'running',
            'error_message' => null,
        ]);

        HistoryEvent::create([
            'user_id' => $photo->user_id,
            'photo_id' => $photo->id,
            'event_type' => 'analysis_running',
            'message' => 'Analysis started.',
        ]);

        // read file bytes
        $disk = $photo->storage_disk;
        $path = $photo->storage_path;

        if (!Storage::disk($disk)->exists($path)) {
            throw new \RuntimeException("File not found: {$disk}:{$path}");
        }

        $fileContent = Storage::disk($disk)->get($path);

        // call FastAPI
        $base = rtrim(config('services.forensic.url'), '/');
        if (!$base) {
            throw new \RuntimeException("FORENSIC_URL not configured. Set it in .env and config/services.php");
        }

        $endpoint = $base . '/analyze';

        $resp = Http::timeout(120)
            ->attach('file', $fileContent, $photo->original_filename)
            ->post($endpoint);

        if (!$resp->successful()) {
            throw new \RuntimeException("Forensic service error: HTTP {$resp->status()} - " . $resp->body());
        }

        $payload = $resp->json();

        $analysis->update([
            'status' => 'done',
            'score' => $payload['score'] ?? null,
            'result_json' => $payload,
        ]);

        HistoryEvent::create([
            'user_id' => $photo->user_id,
            'photo_id' => $photo->id,
            'event_type' => 'analysis_done',
            'message' => 'Analysis completed.',
        ]);
    }

    public function failed(Throwable $e): void
    {
        $analysis = Analysis::with('photo')->find($this->analysisId);
        if (!$analysis) return;

        $analysis->update([
            'status' => 'failed',
            'error_message' => $e->getMessage(),
        ]);

        $photo = $analysis->photo;
        if ($photo) {
            HistoryEvent::create([
                'user_id' => $photo->user_id,
                'photo_id' => $photo->id,
                'event_type' => 'analysis_failed',
                'message' => 'Analysis failed: ' . $e->getMessage(),
            ]);
        }
    }
}
