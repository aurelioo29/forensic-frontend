<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-white">
            Confirm Password
        </h1>
        <p class="mt-1 text-sm text-slate-300">
            Security check — enter your password to continue.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div class="relative">
            <label for="password" class="block text-sm font-medium text-slate-200">Password</label>

            <div class="relative mt-1">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <!-- lock icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v9a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-9a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5zm-3 8V6a3 3 0 0 1 6 0v3H9z" />
                    </svg>
                </span>

                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="Enter your password"
                    class="w-full rounded-lg bg-black/30 border border-white/15
                 pl-10 pr-3 py-2.5 text-white placeholder:text-slate-400
                 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/40" />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
        </div>

        <!-- Submit -->
        <button type="submit"
            class="group relative w-full overflow-hidden rounded-lg
             bg-gradient-to-r from-blue-600 to-indigo-600
             px-4 py-3 text-sm font-semibold text-white
             shadow-lg shadow-blue-500/30
             transition-all hover:scale-[1.01] hover:shadow-blue-500/50
             focus:outline-none focus:ring-2 focus:ring-blue-400/40">
            <span class="relative z-10">Confirm</span>
            <span class="absolute inset-0 bg-white/10 opacity-0 transition-opacity group-hover:opacity-100"></span>
        </button>

        <div class="pt-2 text-center">
            <a href="{{ route('dashboard') }}"
                class="text-sm text-slate-300 underline underline-offset-4 hover:text-white">
                Cancel
            </a>
        </div>
    </form>
</x-guest-layout>
