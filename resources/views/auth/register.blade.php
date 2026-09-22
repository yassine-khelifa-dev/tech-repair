<x-guest-layout>
    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-wide text-cyan-300">Tech Repair</p>
        <h2 class="mt-3 text-3xl font-extrabold tracking-normal text-white">Register</h2>
        <p class="mt-2 text-sm leading-6 text-gray-400">
            Create your account to start handling smartphone repair requests.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-200">
                {{ __('Name') }}
            </label>
            <input
                id="name"
                class="mt-2 block w-full rounded-md border border-white/10 bg-gray-950/70 px-4 py-3 text-white shadow-sm outline-none transition placeholder:text-gray-500 focus:border-cyan-300 focus:ring-2 focus:ring-cyan-300/30"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Your name"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-300" />
        </div>

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
                autocomplete="new-password"
                placeholder="Create a password"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-300" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-200">
                {{ __('Confirm Password') }}
            </label>
            <input
                id="password_confirmation"
                class="mt-2 block w-full rounded-md border border-white/10 bg-gray-950/70 px-4 py-3 text-white shadow-sm outline-none transition placeholder:text-gray-500 focus:border-cyan-300 focus:ring-2 focus:ring-cyan-300/30"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Confirm your password"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-300" />
        </div>

        <button
            type="submit"
            class="flex w-full items-center justify-center rounded-md bg-cyan-400 px-5 py-3 text-sm font-extrabold text-gray-950 shadow-lg shadow-cyan-400/20 transition hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-gray-950"
        >
            {{ __('Register') }}
        </button>

        <p class="text-center text-sm text-gray-400">
            {{ __('Already registered?') }}
            <a href="{{ route('login') }}" class="font-bold text-cyan-300 transition hover:text-cyan-200">
                {{ __('Login') }}
            </a>
        </p>
    </form>
</x-guest-layout>
