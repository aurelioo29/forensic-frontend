<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-white">
            Verify Email
        </h1>
        <p class="mt-1 text-sm text-slate-300">
            Check your inbox and confirm your address to continue.
        </p>
    </div>

    <div class="rounded-xl border border-white/10 bg-black/20 p-4 text-sm text-slate-200 leading-relaxed">
        We sent a verification link to your email.
        Click the link to activate your account.

        <div class="mt-2 text-xs text-slate-400">
            Didn’t receive it? No worries — you can resend below.
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mt-4 rounded-xl border border-emerald-400/20 bg-emerald-500/10 p-4 text-sm text-emerald-200">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
        <!-- Resend -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="group relative w-full overflow-hidden rounded-lg
               bg-gradient-to-r from-blue-600 to-indigo-600
               px-4 py-3 text-sm font-semibold text-white
               shadow-lg shadow-blue-500/30
               transition-all hover:scale-[1.01] hover:shadow-blue-500/50
               focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                <span class="relative z-10">Resend verification email</span>
                <span class="absolute inset-0 bg-white/10 opacity-0 transition-opacity group-hover:opacity-100"></span>
            </button>
        </form>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full rounded-lg border border-white/15 bg-white/5
               px-4 py-3 text-sm font-semibold text-slate-200
               transition hover:bg-white/10 hover:text-white
               focus:outline-none focus:ring-2 focus:ring-white/20">
                Log out
            </button>
        </form>
    </div>

    <p class="mt-6 text-center text-xs text-slate-500">
        Tip: check Spam/Promotions folder if you don’t see the email.
    </p>
</x-guest-layout>
