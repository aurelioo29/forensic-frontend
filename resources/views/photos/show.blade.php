@if (in_array($latest?->status, ['queued', 'running']))
    <script>
        (function() {
            const POLL_MS = 2000;
            const STOP_AFTER_MS = 2 * 60 * 1000;
            const start = Date.now();

            async function poll() {
                try {
                    const res = await fetch(window.location.href, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        cache: "no-store"
                    });

                    if (!res.ok) return schedule();

                    const html = await res.text();
                    const isDone = html.includes('DONE') || html.includes('Status: done');
                    const isFailed = html.includes('FAILED') || html.includes('Status: failed');

                    if (isDone || isFailed) {
                        window.location.reload();
                        return;
                    }

                    if (Date.now() - start > STOP_AFTER_MS) return;
                    schedule();
                } catch (e) {
                    if (Date.now() - start > STOP_AFTER_MS) return;
                    schedule();
                }
            }

            function schedule() {
                setTimeout(poll, POLL_MS);
            }
            schedule();
        })();
    </script>
@endif

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div class="space-y-1">
                <h2 class="text-xl font-semibold tracking-tight text-white">Photo Detail</h2>
                <p class="text-sm text-slate-300">Preview, indicators, metadata, and analysis history.</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-white
                          bg-white/10 border border-white/15 hover:bg-white/15 transition">
                    <i class="fa-solid fa-arrow-left" class="text-white"></i>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8 space-y-6">

            @if (session('status'))
                <div
                    class="rounded-2xl border border-green-400/20 bg-green-500/10 backdrop-blur-xl p-4 text-green-100 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @php
                // Public URL for preview image (file is served via public/storage symlink)
                $imgUrl = asset('storage/' . $photo->storage_path);

                // Latest analysis payload if available
                $payload = is_array($latest?->result_json) ? $latest->result_json : null;

                // Summary
                $label = data_get($payload, 'summary.label');
                $confidence = data_get($payload, 'summary.confidence');
                $reasons = (array) data_get($payload, 'summary.reasons', []);

                // Metadata
                $exifPresent = data_get($payload, 'metadata.exif_present');
                $dtOriginal = data_get($payload, 'metadata.datetime_original');
                $cameraMake = data_get($payload, 'metadata.camera_make');
                $cameraModel = data_get($payload, 'metadata.camera_model');
                $lensModel = data_get($payload, 'metadata.lens_model');
                $software = data_get($payload, 'metadata.software');
                $iso = data_get($payload, 'metadata.iso');
                $exposureTime = data_get($payload, 'metadata.exposure_time');
                $fnumber = data_get($payload, 'metadata.fnumber');
                $focalLength = data_get($payload, 'metadata.focal_length');
                $width = data_get($payload, 'metadata.width');
                $height = data_get($payload, 'metadata.height');
                $mime = data_get($payload, 'metadata.mime');
                $fileSizeBytes = data_get($payload, 'metadata.file_size_bytes');

                // Indicators
                $softwareTag = data_get($payload, 'indicators.software_tag_detected');
                $metadataStripped = data_get($payload, 'indicators.metadata_stripped');
                $recompress = data_get($payload, 'indicators.recompress_suspected');
                $smReexport = data_get($payload, 'indicators.social_media_reexport_suspected');

                $cameraText = trim(($cameraMake ?: '') . ' ' . ($cameraModel ?: '')) ?: null;

                $formatBool = function ($v) {
                    if ($v === null) {
                        return '—';
                    }
                    return $v ? 'Yes' : 'No';
                };

                $formatBytes = function ($bytes) {
                    if ($bytes === null || !is_numeric($bytes)) {
                        return '—';
                    }
                    $bytes = (float) $bytes;
                    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                    $i = 0;
                    while ($bytes >= 1024 && $i < count($units) - 1) {
                        $bytes /= 1024;
                        $i++;
                    }
                    return round($bytes, 2) . ' ' . $units[$i];
                };

                // Label badge (dashboard-ish)
                $badgeClass = match ($label) {
                    'Likely Edited' => 'bg-red-500/15 text-red-200 border-red-400/20',
                    'Likely Original' => 'bg-green-500/15 text-green-200 border-green-400/20',
                    'Unclear' => 'bg-yellow-500/15 text-yellow-200 border-yellow-400/20',
                    default => 'bg-white/10 text-slate-200 border-white/15',
                };

                // Status chip (dashboard-ish)
                $status = $latest?->status ?? 'none';
                $statusClass = match (true) {
                    $status === 'done' => 'bg-green-500/15 text-green-200 border-green-400/20',
                    in_array($status, ['queued', 'running']) => 'bg-yellow-500/15 text-yellow-200 border-yellow-400/20',
                    $status === 'failed' => 'bg-red-500/15 text-red-200 border-red-400/20',
                    default => 'bg-white/10 text-slate-200 border-white/15',
                };
            @endphp

            {{-- MAIN CARD (glass) --}}
            <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-xl shadow-black/20 p-5">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- LEFT: Preview --}}
                    <div class="lg:col-span-1 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-white">Preview</div>
                            <span class="text-xs text-slate-300">{{ $mime ?: '' }}</span>
                        </div>

                        <div class="rounded-2xl overflow-hidden border border-white/10 bg-black/20">
                            <img class="w-full h-auto object-cover" src="{{ $imgUrl }}" alt="photo"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/800x600?text=Image+Not+Found';">
                        </div>

                        <div
                            class="rounded-2xl border border-white/10 bg-black/20 p-4 text-xs text-slate-300 break-all space-y-2">
                            <div><span class="font-semibold text-slate-200">Filename:</span>
                                {{ $photo->original_filename }}</div>
                            <div><span class="font-semibold text-slate-200">SHA256:</span> {{ $photo->sha256 }}</div>
                            <div><span class="font-semibold text-slate-200">Disk:</span> {{ $photo->storage_disk }}
                            </div>
                            <div><span class="font-semibold text-slate-200">Path:</span> {{ $photo->storage_path }}
                            </div>
                            <div><span class="font-semibold text-slate-200">URL:</span> {{ $imgUrl }}</div>
                        </div>
                    </div>

                    {{-- RIGHT: Analysis --}}
                    <div class="lg:col-span-2 space-y-4">

                        {{-- Latest Analysis --}}
                        <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-5">
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-sm font-semibold text-white">Latest Analysis</div>

                                <div class="flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center rounded-full border px-2 py-1 text-xs {{ $statusClass }}">
                                        {{ strtoupper($status) }}
                                    </span>

                                    @if ($payload && $label)
                                        <span
                                            class="inline-flex items-center rounded-full border px-2 py-1 text-xs {{ $badgeClass }}">
                                            {{ $label }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                                <div class="text-4xl font-extrabold text-white tracking-tight">
                                    {{ $latest?->score !== null ? $latest->score . '/100' : '—' }}
                                </div>

                                <div class="text-xs text-slate-300 sm:text-right space-y-1">
                                    <div>Confidence: <span
                                            class="text-slate-100 font-semibold">{{ $confidence !== null ? $confidence : '—' }}</span>
                                    </div>
                                    <div class="opacity-90">
                                        @if ($status === 'queued')
                                            Waiting in queue…
                                        @elseif($status === 'running')
                                            Analyzing…
                                        @elseif($status === 'done')
                                            Analysis completed.
                                        @elseif($status === 'failed')
                                            Failed: {{ $latest?->error_message }}
                                        @else
                                            No analysis yet.
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-xs text-slate-300/90">
                                Note: This is probabilistic (indicators-based). It cannot count exact “edit times” from
                                a single JPEG.
                            </div>
                        </div>

                        {{-- Indicators --}}
                        @if ($status === 'done' && $payload)
                            <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-5">
                                <div class="text-sm font-semibold text-white mb-3">Indicators</div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                    @php
                                        $indicatorCard = 'rounded-2xl border border-white/10 bg-black/20 p-4';
                                        $k = 'text-xs text-slate-400';
                                        $v = 'font-semibold text-slate-100';
                                    @endphp

                                    <div class="{{ $indicatorCard }}">
                                        <div class="{{ $k }}">Software tag detected</div>
                                        <div class="{{ $v }}">{{ $formatBool($softwareTag) }}</div>
                                    </div>

                                    <div class="{{ $indicatorCard }}">
                                        <div class="{{ $k }}">Metadata stripped / incomplete</div>
                                        <div class="{{ $v }}">{{ $formatBool($metadataStripped) }}</div>
                                    </div>

                                    <div class="{{ $indicatorCard }}">
                                        <div class="{{ $k }}">Social media re-export suspected</div>
                                        <div class="{{ $v }}">{{ $formatBool($smReexport) }}</div>
                                    </div>

                                    <div class="{{ $indicatorCard }}">
                                        <div class="{{ $k }}">Recompression suspected</div>
                                        <div class="{{ $v }}">{{ $formatBool($recompress) }}</div>
                                    </div>

                                    <div class="{{ $indicatorCard }} sm:col-span-2">
                                        <div class="{{ $k }}">EXIF present</div>
                                        <div class="{{ $v }}">{{ $formatBool($exifPresent) }}</div>
                                    </div>
                                </div>

                                {{-- Reasons --}}
                                <div class="mt-5">
                                    <div class="text-sm font-semibold text-white mb-2">Reasons</div>
                                    @if (count($reasons))
                                        <ul class="list-disc ml-5 text-sm text-slate-200 space-y-1">
                                            @foreach ($reasons as $reason)
                                                <li>{{ $reason }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-sm text-slate-300">—</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Metadata Summary --}}
                            <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-5">
                                <div class="text-sm font-semibold text-white mb-3">Metadata Summary</div>

                                @php
                                    $metaCard = 'rounded-2xl border border-white/10 bg-black/20 p-4';
                                    $mk = 'text-xs text-slate-400';
                                    $mv = 'font-semibold text-slate-100';
                                @endphp

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">Date taken (EXIF)</div>
                                        <div class="{{ $mv }}">{{ $dtOriginal ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">Camera</div>
                                        <div class="{{ $mv }}">{{ $cameraText ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">Lens</div>
                                        <div class="{{ $mv }}">{{ $lensModel ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">Software</div>
                                        <div class="{{ $mv }}">{{ $software ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">ISO</div>
                                        <div class="{{ $mv }}">{{ $iso ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">Exposure time</div>
                                        <div class="{{ $mv }}">{{ $exposureTime ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">Aperture (f/)</div>
                                        <div class="{{ $mv }}">{{ $fnumber ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">Focal length (mm)</div>
                                        <div class="{{ $mv }}">{{ $focalLength ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">Dimensions</div>
                                        <div class="{{ $mv }}">
                                            {{ $width && $height ? $width . ' × ' . $height : '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">File size</div>
                                        <div class="{{ $mv }}">{{ $formatBytes($fileSizeBytes) }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">35mm focal length</div>
                                        <div class="{{ $mv }}">
                                            {{ data_get($payload, 'metadata.focal_length_35mm') ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">Camera serial number</div>
                                        <div class="{{ $mv }}">
                                            {{ data_get($payload, 'metadata.camera_serial') ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">EXIF version</div>
                                        <div class="{{ $mv }}">
                                            {{ data_get($payload, 'metadata.exif_version') ?: '—' }}</div>
                                    </div>

                                    <div class="{{ $metaCard }}">
                                        <div class="{{ $mk }}">MIME</div>
                                        <div class="{{ $mv }}">{{ $mime ?: '—' }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Raw JSON Debug --}}
                            <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-5">
                                <div class="text-sm font-semibold text-white mb-3">Raw Result (debug)</div>
                                <pre class="text-xs bg-black/30 border border-white/10 text-slate-200 p-4 rounded-2xl overflow-auto">{{ json_encode($payload, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @endif

                        {{-- History --}}
                        <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-5">
                            <div class="text-sm font-semibold text-white mb-3">History</div>

                            @if ($photo->historyEvents->count())
                                <ol class="space-y-3 text-sm">
                                    @foreach ($photo->historyEvents as $e)
                                        <li
                                            class="rounded-2xl border border-white/10 bg-black/20 p-4 flex items-start justify-between gap-4">
                                            <div>
                                                <div class="font-semibold text-slate-100">{{ $e->event_type }}</div>
                                                <div class="text-slate-300">{{ $e->message }}</div>
                                            </div>
                                            <div class="text-xs text-slate-400 whitespace-nowrap">
                                                {{ $e->created_at->diffForHumans() }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                <div class="text-sm text-slate-300">No history events.</div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
