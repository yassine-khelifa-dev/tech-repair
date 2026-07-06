@extends('layouts.admin')

@section('content')
    <div x-data="{ modal: false, model_selected: null }" class="mx-auto max-w-7xl">
        <div x-cloak x-show="modal" x-transition.opacity @click.self="modal = false" @keydown.escape.window="modal = false"
            class="fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black/70 p-4 backdrop-blur-sm">
            @include('device.model._modal-show')
        </div>

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Device catalog</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Device Models</h1>
                <p class="mt-2 text-sm text-gray-400">Manage model names, brand relationships, type grouping, and configurations.</p>
            </div>

            <a href="{{ route('devicemodel.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Model
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-lg border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-200">
                <svg class="h-5 w-5 flex-none text-emerald-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.86-9.61a.75.75 0 00-1.22-.88l-3.23 4.5-1.54-1.54a.75.75 0 10-1.06 1.06l2.17 2.17a.75.75 0 001.14-.09l3.74-5.22z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-white/10 bg-gray-800/70 shadow-2xl shadow-black/20">
            <div class="border-b border-white/10 px-5 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-base font-semibold text-white">Model list</h2>
                        <p class="mt-1 text-sm text-gray-400">{{ $devicemodels->total() }} total device models</p>
                    </div>
                    <div class="hidden rounded-lg bg-blue-500/10 px-3 py-2 text-sm font-semibold text-blue-200 sm:block">
                        {{ $devicemodels->count() }} on this page
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-900/60 text-xs uppercase tracking-wide text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Model</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Brand</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Type</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Created</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($devicemodels as $devicemodel)
                            <tr class="group transition-colors duration-200 hover:bg-white/[.04]">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/10 text-blue-300 ring-1 ring-blue-400/20 transition-transform duration-200 group-hover:scale-105">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-white">{{ $devicemodel->name }}</div>
                                            <div class="text-xs text-gray-500">ID #{{ $devicemodel->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-white/5 px-2.5 py-1 text-xs font-semibold text-gray-200 ring-1 ring-white/10">
                                        {{ $devicemodel->brand->name ?? 'No brand' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-blue-500/10 px-2.5 py-1 text-xs font-semibold text-blue-200 ring-1 ring-blue-400/20">
                                        {{ $devicemodel->type->name ?? 'No type' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    {{ $devicemodel->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('device-model-configuration.edit', $devicemodel->id) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-purple-400/20 bg-purple-500/10 text-purple-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-purple-300/50 hover:bg-purple-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                            aria-label="Configure {{ $devicemodel->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0015 0m-15 0a7.5 7.5 0 1115 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M12.002 12l-3.75 6.495" />
                                            </svg>
                                        </a>

                                        <button @click="modal = true; model_selected = {{ Js::from($devicemodel) }}" type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-emerald-400/20 bg-emerald-500/10 text-emerald-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300/50 hover:bg-emerald-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                            aria-label="View {{ $devicemodel->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>

                                        <a href="{{ route('devicemodel.edit', $devicemodel->id) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-blue-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-blue-300/50 hover:bg-blue-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                            aria-label="Edit {{ $devicemodel->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('devicemodel.destroy', $devicemodel->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure to delete this device model?')"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-400/20 bg-red-500/10 text-red-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-red-300/50 hover:bg-red-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                                aria-label="Delete {{ $devicemodel->name }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white/5 text-gray-400 ring-1 ring-white/10">
                                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-white">No device models yet</h3>
                                        <p class="mt-1 text-sm text-gray-400">Create the first model and connect it to a brand and type.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($devicemodels->hasPages())
            <div class="mt-5 flex flex-col gap-4 rounded-xl border border-white/10 bg-gray-800/70 px-4 py-3 text-sm text-gray-300 shadow-lg shadow-black/10 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    Showing
                    <span class="font-semibold text-white">{{ $devicemodels->firstItem() }}</span>
                    to
                    <span class="font-semibold text-white">{{ $devicemodels->lastItem() }}</span>
                    of
                    <span class="font-semibold text-white">{{ $devicemodels->total() }}</span>
                    results
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($devicemodels->onFirstPage())
                        <span class="rounded-lg border border-white/10 px-3 py-2 text-gray-500 cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $devicemodels->previousPageUrl() }}"
                            class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">Previous</a>
                    @endif

                    @foreach ($devicemodels->getUrlRange(1, $devicemodels->lastPage()) as $page => $url)
                        @if ($page == $devicemodels->currentPage())
                            <span class="rounded-lg bg-blue-600 px-3 py-2 font-semibold text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($devicemodels->hasMorePages())
                        <a href="{{ $devicemodels->nextPageUrl() }}"
                            class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">Next</a>
                    @else
                        <span class="rounded-lg border border-white/10 px-3 py-2 text-gray-500 cursor-not-allowed">Next</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
