@php
    $isDark = ($variant ?? 'dark') === 'dark';

    $inputClass = $isDark
        ? 'w-full rounded-lg bg-black/30 border border-white/15 pl-10 pr-10 py-2.5 text-white placeholder:text-slate-400 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/40'
        : 'w-full rounded-lg border border-gray-300 px-3 py-2 pr-10 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40';

    // If no left icon, reduce padding-left
    if (!$withLeftIcon) {
        $inputClass = str_replace('pl-10', 'pl-3', $inputClass);
    }

    $capsClass = $isDark ? 'text-amber-300' : 'text-amber-600';
    $meterBg = $isDark ? 'bg-white/10' : 'bg-gray-200';
    $meterText = $isDark ? 'text-slate-300' : 'text-gray-500';

    $inputId = $name . '_' . uniqid();
@endphp

<div class="space-y-1" data-pw data-strength="{{ $confirm ? 'false' : 'true' }}">
    <div class="relative">
        @if ($withLeftIcon)
            <span
                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 {{ $isDark ? 'text-slate-400' : 'text-gray-400' }}">
                <!-- lock icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v9a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-9a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5zm-3 8V6a3 3 0 0 1 6 0v3H9z" />
                </svg>
            </span>
        @endif

        <input id="{{ $inputId }}" type="password" name="{{ $name }}" required
            placeholder="{{ $placeholder }}" autocomplete="{{ $confirm ? 'new-password' : 'current-password' }}"
            class="password-input {{ $inputClass }}" />

        <button type="button" data-pw-toggle
            class="absolute inset-y-0 right-0 flex items-center justify-center pr-3 text-slate-400 hover:text-white rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/40"
            aria-label="Show password" aria-pressed="false">

            <!-- Eye Open -->
            <svg data-eye-open xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15" class="h-5 w-5"
                fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M7.5 11c-2.697 0-4.97-1.378-6.404-3.5C2.53 5.378 4.803 4 7.5 4s4.97 1.378 6.404 3.5C12.47 9.622 10.197 11 7.5 11Zm0-8C4.308 3 1.656 4.706.076 7.235a.5.5 0 0 0 0 .53C1.656 10.294 4.308 12 7.5 12s5.844-1.706 7.424-4.235a.5.5 0 0 0 0-.53C13.344 4.706 10.692 3 7.5 3Zm0 6.5a2 2 0 1 0 0-4a2 2 0 0 0 0 4Z"
                    clip-rule="evenodd" />
            </svg>

            <!-- Eye Closed -->
            <svg data-eye-closed xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24" class="h-5 w-5 hidden"
                fill="currentColor" aria-hidden="true">
                <path
                    d="m15.398 7.23l1.472-1.472C18.749 6.842 20 8.34 20 10c0 3.314-4.958 5.993-10 6a14.734 14.734 0 0 1-3.053-.32l1.747-1.746c.426.044.862.067 1.303.066h.002c-.415 0-.815-.063-1.191-.18l1.981-1.982c.47-.202.847-.579 1.05-1.049l1.98-1.981A4 4 0 0 1 10.022 14C14.267 13.985 18 11.816 18 10c0-.943-1.022-1.986-2.602-2.77zm-9.302 3.645A4 4 0 0 1 9.993 6C5.775 5.985 2 8.178 2 10c0 .896.904 1.877 2.327 2.644L2.869 14.1C1.134 13.028 0 11.585 0 10c0-3.314 4.984-6.017 10-6c.914.003 1.827.094 2.709.262l-1.777 1.776c-.29-.022-.584-.035-.88-.038c.282.004.557.037.823.096l-4.78 4.779zM19.092.707a1 1 0 0 1 0 1.414l-16.97 16.97a1 1 0 1 1-1.415-1.413L17.677.708a1 1 0 0 1 1.415 0z" />
            </svg>
        </button>

    </div>

    <!-- Caps lock -->
    <p class="hidden text-xs {{ $capsClass }}" data-caps-warning>
        ⚠ Caps Lock is ON
    </p>

    <!-- Strength meter -->
    @unless ($confirm)
        <div class="mt-2 hidden" data-strength-meter>
            <div class="h-1.5 w-full rounded-full bg-white/10 overflow-hidden">
                <div class="h-full w-0 rounded-full transition-all duration-200" data-strength-bar></div>
            </div>

            <div class="mt-1 text-[11px] text-slate-300" data-strength-text></div>
        </div>
    @endunless
</div>
