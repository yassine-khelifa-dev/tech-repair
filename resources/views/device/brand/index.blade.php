@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Device catalog</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Brands</h1>
                <p class="mt-2 text-sm text-gray-400">Create and manage device brands used across repair tickets.</p>
            </div>

            <a href="{{ route('brand.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Brand
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
                        <h2 class="text-base font-semibold text-white">Brand list</h2>
                        <p class="mt-1 text-sm text-gray-400">{{ $brands->total() }} total brands</p>
                    </div>
                    <div class="hidden rounded-lg bg-blue-500/10 px-3 py-2 text-sm font-semibold text-blue-200 sm:block">
                        {{ $brands->count() }} on this page
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-900/60 text-xs uppercase tracking-wide text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Brand</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Created</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($brands as $brand)
                            <tr class="group transition-colors duration-200 hover:bg-white/[.04]">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/10 text-blue-300 ring-1 ring-blue-400/20 transition-transform duration-200 group-hover:scale-105">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M4 4a2 2 0 012-2h4l6 6v8a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                                <path d="M11 2v5a1 1 0 001 1h5" fill="#111827" opacity=".4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-white">{{ $brand->name }}</div>
                                            <div class="text-xs text-gray-500">ID #{{ $brand->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    {{ $brand->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('brand.edit', $brand->id) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-blue-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-blue-300/50 hover:bg-blue-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                            aria-label="Edit {{ $brand->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('brand.destroy', $brand->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure to delete this brand?')"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-400/20 bg-red-500/10 text-red-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-red-300/50 hover:bg-red-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                                aria-label="Delete {{ $brand->name }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0115.916 21.75H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white/5 text-gray-400 ring-1 ring-white/10">
                                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M4 4a2 2 0 012-2h4l6 6v8a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-white">No brands yet</h3>
                                        <p class="mt-1 text-sm text-gray-400">Create the first brand to start organizing devices.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($brands->hasPages())
            <div class="mt-5 flex flex-col gap-4 rounded-xl border border-white/10 bg-gray-800/70 px-4 py-3 text-sm text-gray-300 shadow-lg shadow-black/10 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    Showing
                    <span class="font-semibold text-white">{{ $brands->firstItem() }}</span>
                    to
                    <span class="font-semibold text-white">{{ $brands->lastItem() }}</span>
                    of
                    <span class="font-semibold text-white">{{ $brands->total() }}</span>
                    results
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($brands->onFirstPage())
                        <span class="rounded-lg border border-white/10 px-3 py-2 text-gray-500 cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="{{ $brands->previousPageUrl() }}"
                            class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">
                            Previous
                        </a>
                    @endif

                    @foreach ($brands->getUrlRange(1, $brands->lastPage()) as $page => $url)
                        @if ($page == $brands->currentPage())
                            <span class="rounded-lg bg-blue-600 px-3 py-2 font-semibold text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($brands->hasMorePages())
                        <a href="{{ $brands->nextPageUrl() }}"
                            class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">
                            Next
                        </a>
                    @else
                        <span class="rounded-lg border border-white/10 px-3 py-2 text-gray-500 cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
