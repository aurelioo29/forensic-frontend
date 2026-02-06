<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Analysis;
use App\Models\HistoryEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Jobs\AnalyzePhotoJob;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $photos = Photo::query()
            ->where('user_id', Auth::id())
            ->with(['latestAnalysis'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('original_filename', 'like', "%{$q}%")
                        ->orWhere('sha256', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('photos.dashboard', compact('photos', 'q'));
    }

    public function create()
    {
        return view('photos.upload');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photo' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:20480'], // 20MB
            'is_private' => ['nullable', 'boolean'],
        ]);

        $file = $request->file('photo');

        // Hash file (SHA-256)
        $sha256 = hash_file('sha256', $file->getRealPath());

        // Store file
        $disk = config('filesystems.default');
        $path = $file->storeAs(
            'photos/' . now()->format('Y/m'),
            Str::uuid()->toString() . '.' . $file->getClientOriginalExtension(),
            $disk
        );

        // Create Photo record
        $photo = Photo::create([
            'user_id' => Auth::id(),
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'storage_disk' => $disk,
            'storage_path' => $path,
            'sha256' => $sha256,
            'is_private' => (bool)($data['is_private'] ?? true),
        ]);

        // Create Analysis record (queued)
        $analysis = Analysis::create([
            'photo_id' => $photo->id,
            'status' => 'queued',
            'score' => null,
            'result_json' => null,
        ]);

        // History events
        HistoryEvent::create([
            'user_id' => Auth::id(),
            'photo_id' => $photo->id,
            'event_type' => 'uploaded',
            'message' => 'Photo uploaded.',
        ]);

        HistoryEvent::create([
            'user_id' => Auth::id(),
            'photo_id' => $photo->id,
            'event_type' => 'analysis_queued',
            'message' => 'Analysis queued.',
        ]);

        // Next step: dispatch Job AnalyzePhotoJob (kita bikin setelah ini)
        AnalyzePhotoJob::dispatch($analysis->id);

        return redirect()->route('photos.show', $photo)->with('status', 'Uploaded! Analysis queued.');
    }

    public function show(Photo $photo)
    {
        abort_unless($photo->user_id === Auth::id(), 403);

        $photo->load(['analyses.artifacts', 'historyEvents' => function ($q) {
            $q->latest();
        }]);

        $latest = $photo->latestAnalysis;

        return view('photos.show', compact('photo', 'latest'));
    }
}
