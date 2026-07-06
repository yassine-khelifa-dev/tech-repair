@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('devicemodel.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 transition hover:text-blue-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Back to device models
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-white/10 bg-gray-800/70 shadow-2xl shadow-black/20">
            <div class="border-b border-white/10 px-6 py-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-500/10 text-blue-300 ring-1 ring-blue-400/20">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Model settings</p>
                        <h1 class="mt-1 text-2xl font-bold text-white">Edit Device Model</h1>
                    </div>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-400">
                    Update this model name, brand, or device type.
                </p>
            </div>

            <form action="{{ route('devicemodel.update', $devicemodel->id) }}" method="post" class="px-6 py-6">
                @csrf
                @method('PUT')

                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-200">Model name</label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="name"
                                value="{{ old('name', $devicemodel->name) }}"
                                type="text"
                                name="name"
                                autocomplete="off"
                                placeholder="Example: iPhone 15 Pro, Galaxy S24"
                                class="block w-full rounded-lg border border-white/10 bg-gray-950/60 py-3 pl-11 pr-4 text-sm text-white shadow-sm outline-none transition placeholder:text-gray-500 focus:border-blue-300 focus:ring-2 focus:ring-blue-400/30" />
                        </div>
                        @error('name')
                            <div class="mt-2 text-sm text-red-300">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="brand_id" class="block text-sm font-semibold text-gray-200">Brand</label>
                        <select id="brand_id"
                            name="brand_id"
                            class="mt-2 block w-full rounded-lg border border-white/10 bg-gray-950/60 px-4 py-3 text-sm text-white shadow-sm outline-none transition focus:border-blue-300 focus:ring-2 focus:ring-blue-400/30">
                            <option class="bg-gray-950 text-white" value="">Choose a brand</option>
                            @foreach ($brands as $brand)
                                <option class="bg-gray-950 text-white" value="{{ $brand->id }}" {{ old('brand_id', $devicemodel->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="mt-2 text-sm text-red-300">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="device_type_id" class="block text-sm font-semibold text-gray-200">Device type</label>
                        <select id="device_type_id"
                            name="device_type_id"
                            class="mt-2 block w-full rounded-lg border border-white/10 bg-gray-950/60 px-4 py-3 text-sm text-white shadow-sm outline-none transition focus:border-blue-300 focus:ring-2 focus:ring-blue-400/30">
                            <option class="bg-gray-950 text-white" value="">Choose a type</option>
                            @foreach ($devicetypes as $devicetype)
                                <option class="bg-gray-950 text-white" value="{{ $devicetype->id }}" {{ old('device_type_id', $devicemodel->device_type_id) == $devicetype->id ? 'selected' : '' }}>
                                    {{ $devicetype->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('device_type_id')
                            <div class="mt-2 text-sm text-red-300">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('devicemodel.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-gray-200 transition hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800">
                        Cancel
                    </a>

                    <button value="save" name="action" type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                        </svg>
                        Update Model
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
