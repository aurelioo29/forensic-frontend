<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-white">
            Reset Password
        </h1>
        <p class="mt-1 text-sm text-slate-300">
            Set a new password for your account
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="relative">
            <label for="email" class="block text-sm font-medium text-slate-200">Email</label>

            <div class="relative mt-1">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <!-- mail icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4.236-8 4.8-8-4.8V6l8 4.8L20 6v2.236z" />
                    </svg>
                </span>

                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                    autofocus autocomplete="username" placeholder="you@example.com"
                    class="w-full rounded-lg bg-black/30 border border-white/15
                 pl-10 pr-3 py-2.5 text-white placeholder:text-slate-400
                 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/40" />
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
        </div>

        <!-- New Password -->
        <div class="relative">
            <label for="password" class="block text-sm font-medium text-slate-200">New Password</label>

            <div class="relative mt-1">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <!-- lock icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v9a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-9a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5zm-3 8V6a3 3 0 0 1 6 0v3H9z" />
                    </svg>
                </span>

                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Create a strong password"
                    class="w-full rounded-lg bg-black/30 border border-white/15
                 pl-10 pr-3 py-2.5 text-white placeholder:text-slate-400
                 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/40" />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
            <p class="mt-2 text-xs text-slate-400">
                Tip: use 8+ characters with letters, numbers, and symbols if possible.
            </p>
        </div>

        <!-- Confirm Password -->
        <div class="relative">
            <label for="password_confirmation" class="block text-sm font-medium text-slate-200">Confirm Password</label>

            <div class="relative mt-1">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <!-- shield/check icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2 4 5v6c0 5.55 3.84 10.74 8 11 4.16-.26 8-5.45 8-11V5l-8-3zm-1 14-3-3 1.41-1.41L11 13.17l3.59-3.58L16 11l-5 5z" />
                    </svg>
                </span>

                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Repeat your password"
                    class="w-full rounded-lg bg-black/30 border border-white/15
                 pl-10 pr-3 py-2.5 text-white placeholder:text-slate-400
                 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/40" />
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
        </div>

        <!-- Submit -->
        <button type="submit"
            class="group relative w-full overflow-hidden rounded-lg
             bg-gradient-to-r from-blue-600 to-indigo-600
             px-4 py-3 text-sm font-semibold text-white
             shadow-lg shadow-blue-500/30
             transition-all hover:scale-[1.01] hover:shadow-blue-500/50
             focus:outline-none focus:ring-2 focus:ring-blue-400/40">
            <span class="relative z-10">Reset Password</span>
            <span class="absolute inset-0 bg-white/10 opacity-0 transition-opacity group-hover:opacity-100"></span>
        </button>

        <p class="pt-2 text-center text-sm text-slate-300">
            Remembered it?
            <a href="{{ route('login') }}"
                class="font-medium text-white underline underline-offset-4 hover:text-blue-200">
                Back to login
            </a>
        </p>
    </form>
</x-guest-layout>
