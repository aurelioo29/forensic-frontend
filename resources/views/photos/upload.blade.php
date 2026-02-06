<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-white">Upload Photo</h2>
                <p class="text-sm text-slate-300">Drag & drop or select an image to analyze.</p>
            </div>

            <a href="{{ route('dashboard') }}"
                class="text-sm text-slate-200 hover:text-white underline underline-offset-4">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- Main upload card --}}
        <div
            class="lg:col-span-3 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-xl shadow-black/20 p-6">
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-400/20 bg-red-500/10 p-4 text-sm text-red-200">
                    <div class="font-semibold text-red-100 mb-2">Upload error</div>
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Dropzone --}}
                <label for="photo"
                    class="group block cursor-pointer rounded-2xl border border-dashed border-white/20 bg-black/20
                              p-6 text-center hover:bg-black/25 hover:border-white/30 transition">
                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 border border-white/15 text-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2a1 1 0 0 1 1 1v9.586l2.293-2.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L11 12.586V3a1 1 0 0 1 1-1z" />
                            <path
                                d="M4 14a2 2 0 0 1 2-2h1a1 1 0 0 1 0 2H6v6h12v-6h-1a1 1 0 1 1 0-2h1a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6z" />
                        </svg>
                    </div>

                    <div class="mt-3 text-sm font-semibold text-white">
                        Drag & drop your photo here
                        <span class="text-slate-300 font-normal">or click to upload</span>
                    </div>
                    <div class="mt-1 text-xs text-slate-300">
                        JPG / PNG recommended. Social media images may lose metadata.
                    </div>

                    <input id="photo" type="file" name="photo" accept="image/*" required class="sr-only">
                </label>

                {{-- Private checkbox --}}
                <label class="inline-flex items-center gap-2 text-sm text-slate-200">
                    <input type="checkbox" name="is_private" value="1" checked
                        class="rounded border-white/20 bg-white/10 text-blue-500 focus:ring-blue-400/30" />
                    Private analysis
                    <span class="text-slate-400 text-xs">(recommended)</span>
                </label>

                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold text-white
                               bg-gradient-to-r from-blue-600 to-indigo-600
                               shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.01] transition">
                    Upload & Queue Analysis
                </button>
            </form>
        </div>

        {{-- Side info card --}}
        <div
            class="lg:col-span-2 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-xl shadow-black/20 p-6">
            <div class="text-white font-semibold">Tips</div>
            <ul class="mt-3 space-y-3 text-sm text-slate-200">
                <li class="flex gap-2">
                    <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-blue-400/80"></span>
                    <span>Photos from WhatsApp / IG often get resized & metadata stripped.</span>
                </li>
                <li class="flex gap-2">
                    <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-indigo-400/80"></span>
                    <span>If you need EXIF accuracy, use the original file (not screenshot).</span>
                </li>
                <li class="flex gap-2">
                    <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-blue-400/80"></span>
                    <span>PNG can hide JPEG recompression signals (because it’s not JPEG anymore).</span>
                </li>
            </ul>

            <div class="mt-6 rounded-xl border border-white/10 bg-black/20 p-4 text-xs text-slate-300">
                <div class="font-semibold text-slate-200">Why “Unclear” happens</div>
                <div class="mt-1">
                    Your system is indicator-based. Some edits don’t leave reliable traces in EXIF, and recompression
                    detection
                    is mostly JPEG-focused.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
