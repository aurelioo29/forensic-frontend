<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-white">
            Secure Login
        </h1>
        <p class="mt-1 text-sm text-slate-300">
            Access your forensic workspace
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-200">
                Email or Username
            </label>

            <div class="relative mt-1">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4.236-8 4.8-8-4.8V6l8 4.8L20 6v2.236z" />
                    </svg>
                </span>

                <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username" placeholder="Login with email or username"
                    class="w-full rounded-lg bg-black/30 border border-white/15
                           pl-10 pr-3 py-2.5 text-white placeholder:text-slate-400
                           outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/40" />
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
        </div>

        <!-- Password (component) -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label class="block text-sm font-medium text-slate-200">Password</label>

                @if (Route::has('password.request'))
                    <a class="text-xs text-slate-300 hover:text-white underline underline-offset-4"
                        href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>

            <x-password-input name="password" placeholder="••••••••" variant="dark" :with-left-icon="true" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
        </div>


        <!-- Remember + Register -->
        <div class="flex items-center justify-between pt-1">
            <label class="inline-flex items-center gap-2 text-sm text-slate-200">
                <input type="checkbox" name="remember"
                    class="rounded border-white/20 bg-white/10 text-blue-500
                           focus:ring-blue-400/30" />
                Remember me
            </label>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="text-sm text-slate-300 hover:text-white underline underline-offset-4">
                    Register
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit"
            class="group relative w-full overflow-hidden rounded-lg
                   bg-gradient-to-r from-blue-600 to-indigo-600
                   px-4 py-3 text-sm font-semibold text-white
                   shadow-lg shadow-blue-500/30
                   transition-all hover:scale-[1.01] hover:shadow-blue-500/50
                   focus:outline-none focus:ring-2 focus:ring-blue-400/40">
            <span class="relative z-10">Log in</span>
            <span
                class="absolute inset-0 bg-white/10 opacity-0
                       transition-opacity group-hover:opacity-100"></span>
        </button>

        @if (Route::has('register'))
            <p class="pt-2 text-center text-sm text-slate-300">
                Don’t have an account?
                <a href="{{ route('register') }}"
                    class="font-medium text-white underline underline-offset-4
                          hover:text-blue-200">
                    Register
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>
