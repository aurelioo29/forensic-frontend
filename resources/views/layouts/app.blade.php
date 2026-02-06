<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-950 text-slate-100">
    {{-- Background like auth --}}
    <div class="min-h-screen overflow-x-hidden">
        <div class="fixed inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 via-indigo-400 to-blue-400 opacity-25"></div>
            <div class="absolute inset-0 bg-slate-950/80"></div>

            {{-- soft blobs --}}
            <div class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-blue-500/25 blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-indigo-500/25 blur-3xl"></div>
        </div>

        @include('layouts.navigation')

        {{-- Page heading --}}
        @isset($header)
            <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/30 backdrop-blur">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-5">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
