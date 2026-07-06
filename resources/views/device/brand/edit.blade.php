@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('brand.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 transition hover:text-blue-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Back to brands
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-white/10 bg-gray-800/70 shadow-2xl shadow-black/20">
            <div class="border-b border-white/10 px-6 py-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-500/10 text-blue-300 ring-1 ring-blue-400/20">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M4 4a2 2 0 012-2h4l6 6v8a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                            <path d="M11 2v5a1 1 0 001 1h5" fill="#111827" opacity=".4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Brand settings</p>
                        <h1 class="mt-1 text-2xl font-bold text-white">Edit Brand</h1>
                    </div>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-400">
                    Update the display name for this brand. Existing device records will continue using this brand.
                </p>
            </div>

            <form action="{{ route('brand.update', $brand->id) }}" method="POST" class="px-6 py-6">
                @method('PUT')
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-200">Brand name</label>
                    <div class="relative mt-2">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="name"
                            value="{{ old('name', $brand->name) }}"
                            type="text"
                            name="name"
                            autocomplete="off"
                            placeholder="Example: Apple, Samsung, Xiaomi"
                            class="block w-full rounded-lg border border-white/10 bg-gray-950/60 py-3 pl-11 pr-4 text-sm text-white shadow-sm outline-none transition placeholder:text-gray-500 focus:border-blue-300 focus:ring-2 focus:ring-blue-400/30" />
                    </div>
                    @error('name')
                        <div class="mt-2 text-sm text-red-300">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('brand.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-gray-200 transition hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                        </svg>
                        Update Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
