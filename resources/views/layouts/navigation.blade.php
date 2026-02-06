<nav x-data="{ open: false }"
    class="relative z-40 border-b border-white/10 bg-slate-950/30 backdrop-blur supports-[backdrop-filter]:bg-slate-950/20">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            <!-- Left -->
            <div class="flex items-center gap-3">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}"
                    class="group inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-7 w-7 text-white/90 group-hover:text-white transition" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M9 3a1 1 0 0 0-.894.553L7.382 5H5a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3h-2.382l-.724-1.447A1 1 0 0 0 14 3H9zm3 16a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2.2a2.8 2.8 0 1 0 0-5.6 2.8 2.8 0 0 0 0 5.6z" />
                    </svg>

                    <div class="leading-tight">
                        <div class="text-sm font-semibold text-white">Photo Forensics</div>
                        <div class="text-[11px] text-slate-300">Dashboard</div>
                    </div>
                </a>

                <!-- Desktop Links -->
                <div class="hidden sm:flex items-center gap-1 ml-2">
                    <a href="{{ route('dashboard') }}"
                        class="rounded-xl px-3 py-2 text-sm font-medium transition
                            {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white border border-white/10' : 'text-slate-200 hover:text-white hover:bg-white/5' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('photos.create') }}"
                        class="rounded-xl px-3 py-2 text-sm font-medium transition
                            {{ request()->routeIs('photos.create') ? 'bg-white/10 text-white border border-white/10' : 'text-slate-200 hover:text-white hover:bg-white/5' }}">
                        Upload
                    </a>
                </div>
            </div>

            <!-- Right -->
            <div class="hidden sm:flex items-center gap-3">

                <!-- CTA Upload -->
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

                <!-- Settings Dropdown -->
                <div class="relative z-50" x-data="{ dd: false }">
                    <button type="button" @click="dd = !dd" @keydown.escape.window="dd = false"
                        class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium
                               text-slate-200 hover:text-white hover:bg-white/5 transition
                               focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <div
                            class="h-8 w-8 rounded-full bg-white/10 border border-white/15 flex items-center justify-center text-white">
                            <span class="text-xs font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>

                        <div class="text-left">
                            <div class="text-sm font-semibold leading-tight text-white">{{ Auth::user()->name }}</div>
                            <div class="text-[11px] text-slate-300 leading-tight">{{ Auth::user()->email }}</div>
                        </div>

                        <svg class="h-4 w-4 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown panel -->
                    <div x-cloak x-show="dd" @click.outside="dd = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute right-0 mt-2 z-[9999] w-56 overflow-hidden rounded-2xl
                               border border-white/10 bg-slate-950/80 backdrop-blur shadow-xl shadow-black/30">

                        <div class="px-4 py-3 border-b border-white/10">
                            <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-slate-300 break-all">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="p-2">
                            <a href="{{ route('profile.edit') }}"
                                class="block rounded-xl px-3 py-2 text-sm text-slate-200 hover:text-white hover:bg-white/5 transition">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left rounded-xl px-3 py-2 text-sm text-red-200 hover:text-red-100 hover:bg-red-500/10 transition">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="flex sm:hidden">
                <button type="button" @click="open = !open"
                    class="inline-flex items-center justify-center rounded-xl p-2 text-slate-200 hover:text-white hover:bg-white/5
                           focus:outline-none focus:ring-2 focus:ring-blue-400/40 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="mx-auto max-w-7xl px-4 pb-4">
            <div class="mt-2 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-3 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="block rounded-xl px-3 py-2 text-sm font-medium transition
                        {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white border border-white/10' : 'text-slate-200 hover:text-white hover:bg-white/5' }}">
                    Dashboard
                </a>

                <a href="{{ route('photos.create') }}"
                    class="block rounded-xl px-3 py-2 text-sm font-medium transition
                        {{ request()->routeIs('photos.create') ? 'bg-white/10 text-white border border-white/10' : 'text-slate-200 hover:text-white hover:bg-white/5' }}">
                    Upload
                </a>

                <div class="my-2 border-t border-white/10"></div>

                <a href="{{ route('profile.edit') }}"
                    class="block rounded-xl px-3 py-2 text-sm text-slate-200 hover:text-white hover:bg-white/5 transition">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left rounded-xl px-3 py-2 text-sm text-red-200 hover:text-red-100 hover:bg-red-500/10 transition">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
