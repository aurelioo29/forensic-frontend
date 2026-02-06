<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-white">Dashboard</h2>
                <p class="text-sm text-slate-300">Browse uploads, inspect hashes, and open analysis results.</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('photos.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-white
                           bg-gradient-to-r from-blue-600 to-indigo-600
                           shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.01] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2a1 1 0 0 1 1 1v7h7a1 1 0 1 1 0 2h-7v7a1 1 0 1 1-2 0v-7H4a1 1 0 1 1 0-2h7V3a1 1 0 0 1 1-1z" />
                    </svg>
                    Upload Photo
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Search card --}}
    <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-xl shadow-black/20 p-5">
        <form class="flex flex-col gap-3 sm:flex-row sm:items-center" method="GET" action="{{ route('dashboard') }}">
            <div class="relative w-full">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M10 2a8 8 0 1 1 5.293 14.293l3.707 3.707a1 1 0 0 1-1.414 1.414l-3.707-3.707A8 8 0 0 1 10 2zm0 2a6 6 0 1 0 0 12a6 6 0 0 0 0-12z" />
                    </svg>
                </span>

                <input name="q" value="{{ $q }}" placeholder="Search filename or hash…"
                    class="w-full rounded-xl bg-black/30 border border-white/15
                           pl-10 pr-3 py-2.5 text-white placeholder:text-slate-400
                           outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/40" />
            </div>

            <button
                class="inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold text-white
                       bg-white/10 border border-white/15 hover:bg-white/15 transition">
                Search
            </button>
        </form>
    </div>

    {{-- Grid --}}
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($photos as $p)
            @php
                $status = $p->latestAnalysis?->status ?? 'none';
                $score = $p->latestAnalysis?->score;

                $badge = match (true) {
                    $status === 'done' => 'bg-green-500/15 text-green-200 border-green-400/20',
                    in_array($status, ['queued', 'running']) => 'bg-yellow-500/15 text-yellow-200 border-yellow-400/20',
                    $status === 'failed' => 'bg-red-500/15 text-red-200 border-red-400/20',
                    default => 'bg-white/10 text-slate-200 border-white/15',
                };
            @endphp

            <a href="{{ route('photos.show', $p) }}"
                class="group rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-xl shadow-black/20
                      hover:bg-white/10 hover:border-white/15 transition overflow-hidden">

                {{-- thumb (optional) --}}
                <div class="h-36 bg-black/20">
                    @php
                        // kalau kamu punya path storage untuk thumbnail / original image, pakai di sini
                        // contoh: $thumb = Storage::url($p->path);
                        $thumb = null;
                    @endphp

                    @if ($thumb)
                        <img src="{{ $thumb }}" alt="" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-70" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M4 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4zm2 0v16h12V4H6zm2 12 2.5-3 1.5 2 2-3 3 4H8z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-semibold text-white">
                                {{ $p->original_filename }}
                            </div>
                            <div class="mt-1 text-xs text-slate-300 break-all">
                                {{ $p->sha256 }}
                            </div>
                        </div>

                        <div class="shrink-0 text-right">
                            <span
                                class="inline-flex items-center rounded-full border px-2 py-1 text-xs {{ $badge }}">
                                {{ strtoupper($status) }}
                            </span>
                            <div class="mt-2 text-xs text-slate-200">
                                {{ $score !== null ? $score . '/100' : '—' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between text-xs text-slate-300">
                        <span class="inline-flex items-center gap-1">
                            <span class="h-2 w-2 rounded-full bg-blue-400/80"></span>
                            Open details
                        </span>
                        <span class="opacity-80 group-hover:opacity-100 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-8 text-center">
                <div class="text-white font-semibold">No photos yet.</div>
                <div class="mt-1 text-sm text-slate-300">Upload one and start analysis.</div>
                <a href="{{ route('photos.create') }}"
                    class="mt-4 inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-white
                          bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition">
                    Upload Photo
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{-- pagination styling default breeze; kalau mau kita bikin dark style juga --}}
        {{ $photos->links() }}
    </div>
</x-app-layout>
