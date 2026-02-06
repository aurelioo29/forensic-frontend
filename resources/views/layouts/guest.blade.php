<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Photo Forensics') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<!-- IMPORTANT:
       - overflow-hidden: no scrollbars in body
       - h-dvh: dynamic viewport height (lebih akurat dari 100vh di browser modern)
       - antialiased + bg fallback -->

<body class="font-sans antialiased text-gray-900 overflow-hidden bg-black">
    <!-- Wrapper: fixed 1-screen -->
    <div class="h-dvh w-screen overflow-hidden">
        <!-- Grid: full height -->
        <div class="h-full w-full grid grid-cols-1 lg:grid-cols-2">

            <!-- LEFT -->
            <div class="hidden lg:flex relative items-center justify-center bg-gray-50 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white via-gray-50 to-gray-100"></div>

                <!-- Inner content: ensure it never creates overflow -->
                <div class="relative w-full max-w-xl px-12">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-2xl bg-blue-600 flex items-center justify-center shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M9 3a1 1 0 0 0-.894.553L7.382 5H5a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3h-2.382l-.724-1.447A1 1 0 0 0 14 3H9zm3 16a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2.2a2.8 2.8 0 1 0 0-5.6 2.8 2.8 0 0 0 0 5.6z" />
                            </svg>
                        </div>

                        <div>
                            <div class="text-3xl font-bold tracking-tight">
                                Photo <span class="text-blue-600">Forensics</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                Verify Your Photos. Uncover the Truth.
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border bg-white px-3 py-1 text-xs text-gray-600">
                            <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                            Upload → Analyze → Reveal
                        </div>

                        <p class="mt-4 text-sm text-gray-600 leading-relaxed max-w-lg">
                            Check metadata, detect editing indicators, and generate evidence artifacts. Built for
                            practical,
                            explainable results — not magic claims.
                        </p>
                    </div>

                    <div class="mt-8 grid grid-cols-3 gap-3 text-xs text-gray-600">
                        <div class="rounded-xl border bg-white p-4 shadow-sm">
                            <div class="font-semibold text-gray-900">EXIF</div>
                            <div class="mt-1 text-gray-500">Camera & timestamp</div>
                        </div>
                        <div class="rounded-xl border bg-white p-4 shadow-sm">
                            <div class="font-semibold text-gray-900">Indicators</div>
                            <div class="mt-1 text-gray-500">Software & stripping</div>
                        </div>
                        <div class="rounded-xl border bg-white p-4 shadow-sm">
                            <div class="font-semibold text-gray-900">Artifacts</div>
                            <div class="mt-1 text-gray-500">ELA (next)</div>
                        </div>
                    </div>

                    <div class="mt-10 rounded-2xl border bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold text-gray-900">Why Photo Forensics?</div>
                        <ul class="mt-3 space-y-2 text-sm text-gray-600">
                            <li class="flex gap-2">
                                <span class="mt-1 h-1.5 w-1.5 rounded-full bg-blue-600"></span>
                                Verify camera & metadata authenticity
                            </li>
                            <li class="flex gap-2">
                                <span class="mt-1 h-1.5 w-1.5 rounded-full bg-blue-600"></span>
                                Detect editing indicators (software tags, stripping)
                            </li>
                            <li class="flex gap-2">
                                <span class="mt-1 h-1.5 w-1.5 rounded-full bg-blue-600"></span>
                                Evidence-based, explainable outputs
                            </li>
                        </ul>
                    </div>

                    <div class="mt-10 text-xs text-gray-400">
                        © {{ date('Y') }} {{ config('app.name', 'Photo Forensics') }}. All rights reserved.
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div
                class="relative overflow-hidden
                    bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))]
                    from-blue-900 via-slate-900 to-black">

                <!-- Ambient glow -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute -top-32 -right-32 h-96 w-96 rounded-full bg-blue-500/20 blur-3xl"></div>
                    <div class="absolute -bottom-32 -left-28 h-96 w-96 rounded-full bg-indigo-500/10 blur-3xl"></div>
                </div>

                <!-- This container centers the card and never overflows the screen -->
                <div class="relative h-full w-full flex items-center justify-center px-6">
                    <!-- On small screens, allow INTERNAL vertical scroll only if needed -->
                    <div
                        class="w-full max-w-md max-h-[calc(100dvh-48px)] overflow-auto
                        overscroll-contain scrollbar-none">
                        <!-- Mobile brand header -->
                        <div class="lg:hidden mb-6">
                            <div class="flex items-center gap-3">
                                <div class="h-11 w-11 rounded-2xl bg-blue-600 flex items-center justify-center shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M9 3a1 1 0 0 0-.894.553L7.382 5H5a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3h-2.382l-.724-1.447A1 1 0 0 0 14 3H9zm3 16a5 5 0 1 1 0-10 5 5 0 0 1 0 10z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xl font-bold text-white">Photo <span
                                            class="text-blue-300">Forensics</span></div>
                                    <div class="text-xs text-slate-300">Upload → Analyze → Reveal</div>
                                </div>
                            </div>
                        </div>

                        <!-- Card -->
                        <div
                            class="relative overflow-hidden rounded-2xl
                          bg-white/10 backdrop-blur-xl
                          border border-white/15
                          shadow-[0_20px_60px_-15px_rgba(0,0,0,0.8)]
                          p-8">
                            <div
                                class="absolute inset-x-0 top-0 h-[2px]
                            bg-gradient-to-r from-blue-400 via-indigo-400 to-blue-400">
                            </div>

                            {{ $slot }}
                        </div>

                        <div class="mt-6 text-center text-xs text-slate-400">
                            Tip: social media images often lose metadata — results may be “Unclear”.
                        </div>
                        <div class="mt-2 text-center text-[11px] text-slate-500">
                            Analysis results are probabilistic — not absolute proof.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
