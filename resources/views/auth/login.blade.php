<x-guest-layout>
    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-wide text-cyan-300">Repair Flow</p>
        <h2 class="mt-3 text-3xl font-extrabold tracking-normal text-white">Login</h2>
        <p class="mt-2 text-sm leading-6 text-gray-400">
            Access your repair dashboard and continue managing smartphone tickets.
        </p>
    </div>

    <x-auth-session-status class="mb-4 text-sm text-cyan-200" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-200">
                {{ __('Email') }}
            </label>
            <input
                id="email"
                class="mt-2 block w-full rounded-md border border-white/10 bg-gray-950/70 px-4 py-3 text-white shadow-sm outline-none transition placeholder:text-gray-500 focus:border-cyan-300 focus:ring-2 focus:ring-cyan-300/30"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="you@example.com"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-300" />
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-200">
                {{ __('Password') }}
            </label>
            <input
                id="password"
                class="mt-2 block w-full rounded-md border border-white/10 bg-gray-950/70 px-4 py-3 text-white shadow-sm outline-none transition placeholder:text-gray-500 focus:border-cyan-300 focus:ring-2 focus:ring-cyan-300/30"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-300" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-white/20 bg-gray-950 text-cyan-400 shadow-sm focus:ring-cyan-300 focus:ring-offset-gray-950"
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-cyan-300 transition hover:text-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-gray-950" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <button
            type="submit"
            class="flex w-full items-center justify-center rounded-md bg-cyan-400 px-5 py-3 text-sm font-extrabold text-gray-950 shadow-lg shadow-cyan-400/20 transition hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-gray-950"
        >
            {{ __('Log in') }}
        </button>

        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-400">
                {{ __('New to Repair Flow?') }}
                <a href="{{ route('register') }}" class="font-bold text-cyan-300 transition hover:text-cyan-200">
                    {{ __('Register') }}
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>
