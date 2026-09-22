@extends('layouts.admin')

@section('content')
    <div x-data="{ modal: false, model_selected: null }" class="mx-auto max-w-7xl">
        <div x-cloak x-show="modal" x-transition.opacity @click.self="modal = false" @keydown.escape.window="modal = false"
            class="fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black/70 p-4 backdrop-blur-sm">
            @include('device.spec-attributes._modal-detail')
        </div>

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Device catalog</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Spec Attributes</h1>
                <p class="mt-2 text-sm text-gray-400">Manage device specification fields, options, and visibility rules.</p>
            </div>

            <a href="{{ route('spec-attribute.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Attribute
            </a>
        </div>

        @if (session('success') || session('updated') || session('deleted'))
            <div @class([
                'mb-6 flex items-center gap-3 rounded-lg border px-4 py-3 text-sm font-medium',
                'border-emerald-400/20 bg-emerald-500/10 text-emerald-200' => session('success'),
                'border-amber-400/20 bg-amber-500/10 text-amber-200' => session('updated'),
                'border-red-400/20 bg-red-500/10 text-red-200' => session('deleted'),
            ])>
                <svg class="h-5 w-5 flex-none" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.86-9.61a.75.75 0 00-1.22-.88l-3.23 4.5-1.54-1.54a.75.75 0 10-1.06 1.06l2.17 2.17a.75.75 0 001.14-.09l3.74-5.22z" clip-rule="evenodd" />
                </svg>
                {{ session('success') ?? (session('updated') ?? session('deleted')) }}
            </div>
        @endif

        <div class="mb-5 grid gap-3 rounded-xl border border-blue-400/15 bg-blue-500/10 p-4 shadow-lg shadow-blue-900/10 md:grid-cols-[1.4fr_1fr]">
            <div>
                <h2 class="text-base font-semibold text-white">What this page is for</h2>
                <p class="mt-1 text-sm leading-6 text-gray-300">
                    Attributes define the fields shown for a device category, such as color, RAM, storage, or screen size. These attributes decide what information can be selected later when configuring a model and creating a repair ticket.
                </p>
            </div>

            <div class="grid gap-2 text-sm text-gray-300 sm:grid-cols-3 md:grid-cols-1">
                <div class="rounded-lg border border-white/10 bg-gray-950/30 px-3 py-2">
                    <span class="font-semibold text-emerald-200">View</span> shows options, categories, and rules.
                </div>
                <div class="rounded-lg border border-white/10 bg-gray-950/30 px-3 py-2">
                    <span class="font-semibold text-blue-200">Edit</span> changes the attribute setup.
                </div>
                <div class="rounded-lg border border-white/10 bg-gray-950/30 px-3 py-2">
                    <span class="font-semibold text-red-200">Delete</span> removes the attribute.
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-white/10 bg-gray-800/70 shadow-2xl shadow-black/20">
            <div class="border-b border-white/10 px-5 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-base font-semibold text-white">Attribute list</h2>
                        <p class="mt-1 text-sm text-gray-400">{{ $spc_attributes->count() }} configured attributes</p>
                    </div>
                    <div class="hidden rounded-lg bg-blue-500/10 px-3 py-2 text-sm font-semibold text-blue-200 sm:block">
                        Options and rules
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-900/60 text-xs uppercase tracking-wide text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Attribute</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Device Types</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Input</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Options</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Rules</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Sort</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Created</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($spc_attributes as $spc_attribute)
                            <tr class="group transition-colors duration-200 hover:bg-white/[.04]">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/10 text-blue-300 ring-1 ring-blue-400/20 transition-transform duration-200 group-hover:scale-105">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.53 1.53 0 01-2.29.95c-1.37-.84-2.94.73-2.1 2.1a1.53 1.53 0 01-.95 2.29c-1.56.38-1.56 2.6 0 2.98a1.53 1.53 0 01.95 2.29c-.84 1.37.73 2.94 2.1 2.1a1.53 1.53 0 012.29.95c.38 1.56 2.6 1.56 2.98 0a1.53 1.53 0 012.29-.95c1.37.84 2.94-.73 2.1-2.1a1.53 1.53 0 01.95-2.29c1.56-.38 1.56-2.6 0-2.98a1.53 1.53 0 01-.95-2.29c.84-1.37-.73-2.94-2.1-2.1a1.53 1.53 0 01-2.29-.95zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-white">{{ $spc_attribute->name }}</div>
                                            <div class="mt-1 font-mono text-xs text-gray-500">{{ $spc_attribute->code }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex max-w-xs flex-wrap gap-2">
                                        @foreach ($spc_attribute->deviceTypes->take(3) as $deviceType)
                                            <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-2.5 py-1 text-xs font-semibold text-indigo-200 ring-1 ring-indigo-400/20">
                                                {{ $deviceType->name }}
                                            </span>
                                        @endforeach

                                        @if ($spc_attribute->deviceTypes->count() > 3)
                                            <button type="button"
                                                @click="modal = true; model_selected = {{ Js::from($spc_attribute) }}"
                                                class="rounded-full bg-white/5 px-2.5 py-1 text-xs font-semibold text-gray-300 ring-1 ring-white/10 transition hover:bg-white/10 hover:text-white">
                                                +{{ $spc_attribute->deviceTypes->count() - 3 }} more
                                            </button>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-blue-500/10 px-2.5 py-1 text-xs font-semibold text-blue-200 ring-1 ring-blue-400/20">
                                        {{ $spc_attribute->input_type }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="min-w-44 space-y-2">
                                        @foreach ($spc_attribute->specOptions->take(3) as $option)
                                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                                <span>
                                                    {{ $option->label }}
                                                    {{ $spc_attribute->unit !== 'None' ? $spc_attribute->unit : '' }}
                                                </span>
                                            </div>
                                        @endforeach

                                        @if ($spc_attribute->specOptions->count() > 3)
                                            <button type="button"
                                                @click="modal = true; model_selected = {{ Js::from($spc_attribute) }}"
                                                class="text-xs font-semibold text-blue-300 transition hover:text-blue-200">
                                                +{{ $spc_attribute->specOptions->count() - 3 }} more options
                                            </button>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <span @class([
                                            'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1',
                                            'bg-emerald-500/10 text-emerald-200 ring-emerald-400/20' => $spc_attribute->is_filterable == 1,
                                            'bg-gray-500/10 text-gray-400 ring-white/10' => $spc_attribute->is_filterable != 1,
                                        ])>
                                            {{ $spc_attribute->is_filterable == 1 ? 'Filterable' : 'Not filterable' }}
                                        </span>
                                        <span @class([
                                            'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1',
                                            'bg-red-500/10 text-red-200 ring-red-400/20' => $spc_attribute->is_required == 1,
                                            'bg-gray-500/10 text-gray-400 ring-white/10' => $spc_attribute->is_required != 1,
                                        ])>
                                            {{ $spc_attribute->is_required == 1 ? 'Required' : 'Optional' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-gray-300">
                                    {{ $spc_attribute->sort_order }}
                                </td>

                                <td class="px-6 py-4 text-gray-300">
                                    {{ $spc_attribute->created_at->diffForHumans() }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        <button type="button"
                                            @click="modal = true; model_selected = {{ Js::from($spc_attribute) }}"
                                            title="Show this attribute details, allowed categories, options, and validation rules"
                                            class="inline-flex min-w-20 items-center justify-center gap-1.5 rounded-lg border border-emerald-400/20 bg-emerald-500/10 px-3 py-2 text-xs font-semibold text-emerald-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300/50 hover:bg-emerald-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                            aria-label="View {{ $spc_attribute->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            View
                                        </button>

                                        <a href="{{ route('spec-attribute.edit', $spc_attribute->id) }}"
                                            title="Edit name, input type, options, category visibility, and required/filterable rules"
                                            class="inline-flex min-w-20 items-center justify-center gap-1.5 rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-blue-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-blue-300/50 hover:bg-blue-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                            aria-label="Edit {{ $spc_attribute->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <form action="{{ route('spec-attribute.destroy', $spc_attribute->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                onclick="return confirm('Are you sure to delete this attribute?')"
                                                title="Delete this attribute and remove it from future model configuration choices"
                                                class="inline-flex min-w-20 items-center justify-center gap-1.5 rounded-lg border border-red-400/20 bg-red-500/10 px-3 py-2 text-xs font-semibold text-red-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-red-300/50 hover:bg-red-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                                aria-label="Delete {{ $spc_attribute->name }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0115.916 21.75H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white/5 text-gray-400 ring-1 ring-white/10">
                                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.53 1.53 0 01-2.29.95c-1.37-.84-2.94.73-2.1 2.1a1.53 1.53 0 01-.95 2.29c-1.56.38-1.56 2.6 0 2.98a1.53 1.53 0 01.95 2.29c-.84 1.37.73 2.94 2.1 2.1a1.53 1.53 0 012.29.95c.38 1.56 2.6 1.56 2.98 0a1.53 1.53 0 012.29-.95c1.37.84 2.94-.73 2.1-2.1a1.53 1.53 0 01.95-2.29c1.56-.38 1.56-2.6 0-2.98a1.53 1.53 0 01-.95-2.29c.84-1.37-.73-2.94-2.1-2.1a1.53 1.53 0 01-2.29-.95zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-white">No spec attributes yet</h3>
                                        <p class="mt-1 text-sm text-gray-400">Create the first attribute to start configuring model specs.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

          @if ($spc_attributes->hasPages())
            <div class="mt-5 flex flex-col gap-4 rounded-xl border border-white/10 bg-gray-800/70 px-4 py-3 text-sm text-gray-300 shadow-lg shadow-black/10 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    Showing
                    <span class="font-semibold text-white">{{ $spc_attributes->firstItem() }}</span>
                    to
                    <span class="font-semibold text-white">{{ $spc_attributes->lastItem() }}</span>
                    of
                    <span class="font-semibold text-white">{{ $spc_attributes->total() }}</span>
                    results
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($spc_attributes->onFirstPage())
                        <span class="rounded-lg border border-white/10 px-3 py-2 text-gray-500 cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="{{ $spc_attributes->previousPageUrl() }}"
                            class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">
                            Previous
                        </a>
                    @endif

                    @foreach ($spc_attributes->getUrlRange(1, $spc_attributes->lastPage()) as $page => $url)
                        @if ($page == $spc_attributes->currentPage())
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

                    @if ($spc_attributes->hasMorePages())
                        <a href="{{ $spc_attributes->nextPageUrl() }}"
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
