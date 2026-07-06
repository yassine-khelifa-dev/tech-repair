@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-blue-400/20 bg-blue-500/10 text-blue-300 shadow-lg shadow-blue-900/20">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 2.25a1.875 1.875 0 011.16 0l1.558.52a1.875 1.875 0 001.802-.354l1.36-.98a1.875 1.875 0 012.54.18l1.01 1.01a1.875 1.875 0 01.18 2.54l-.98 1.36a1.875 1.875 0 00-.354 1.802l.52 1.558a1.875 1.875 0 010 1.16l-.52 1.558a1.875 1.875 0 00.354 1.802l.98 1.36a1.875 1.875 0 01-.18 2.54l-1.01 1.01a1.875 1.875 0 01-2.54.18l-1.36-.98a1.875 1.875 0 00-1.802-.354l-1.558.52a1.875 1.875 0 01-1.16 0l-1.558-.52a1.875 1.875 0 00-1.802.354l-1.36.98a1.875 1.875 0 01-2.54-.18l-1.01-1.01a1.875 1.875 0 01-.18-2.54l.98-1.36a1.875 1.875 0 00.354-1.802l-.52-1.558a1.875 1.875 0 010-1.16l.52-1.558a1.875 1.875 0 00-.354-1.802l-.98-1.36a1.875 1.875 0 01.18-2.54l1.01-1.01a1.875 1.875 0 012.54-.18l1.36.98a1.875 1.875 0 001.802.354l1.558-.52z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Repair center</p>
                    <h1 class="mt-1 text-3xl font-bold text-white">Repair Tickets</h1>
                    <p class="mt-1 text-sm text-gray-400">Track active repairs, customer devices, and ticket status.</p>
                </div>
            </div>

            <a href="{{ route('repair-tickets.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Ticket
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

        @include('repair.partials._filters', [
            'action' => route('repair-tickets.index'),
            'status' => \App\Enums\RepairStatus::cases(),
        ])

        <div class="mt-5 overflow-hidden rounded-xl border border-white/10 bg-gray-800/70 shadow-2xl shadow-black/20">
            <div class="border-b border-white/10 px-5 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-base font-semibold text-white">Ticket list</h2>
                        <p class="mt-1 text-sm text-gray-400">{{ $tickets->total() }} total tickets</p>
                    </div>
                    <div class="hidden rounded-lg bg-blue-500/10 px-3 py-2 text-sm font-semibold text-blue-200 sm:block">
                        {{ $tickets->count() }} on this page
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-900/60 text-xs uppercase tracking-wide text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Ticket</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Customer</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Device</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Received</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($tickets as $ticket)
                            <tr onclick="window.location='{{ route('repair-tickets.show', $ticket->id) }}'"
                                class="group cursor-pointer transition-colors duration-200 hover:bg-white/[.04]">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/10 text-blue-300 ring-1 ring-blue-400/20 transition-transform duration-200 group-hover:scale-105">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v2h14V5a2 2 0 00-2-2H5zm12 6H3v6a2 2 0 002 2h10a2 2 0 002-2V9zm-9 2a1 1 0 100 2h4a1 1 0 100-2H8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-white">{{ $ticket->ticket_number }}</div>
                                            <div class="text-xs text-gray-500">ID #{{ $ticket->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-200">{{ $ticket->customer->fullname }}</div>
                                    <div class="mt-1 text-xs text-gray-500">{{ $ticket->customer->phone }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-200">{{ $ticket->deviceModel->name }}</div>
                                    <div class="mt-1 text-xs text-gray-500">{{ $ticket->deviceModel->brand->name }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <x-status-badge :status="$ticket->status" />
                                </td>

                                <td class="px-6 py-4 text-gray-300">
                                    <span title="{{ $ticket->received_at }}">{{ $ticket->received_at }}</span>
                                </td>

                                <td class="px-6 py-4" onclick="event.stopPropagation()">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('repair-tickets.show', $ticket->id) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-emerald-400/20 bg-emerald-500/10 text-emerald-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300/50 hover:bg-emerald-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                            aria-label="View {{ $ticket->ticket_number }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.981l7.5-4.039a2.25 2.25 0 012.134 0l7.5 4.039a2.25 2.25 0 011.183 1.98V19.5z" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('repair-tickets.edit', $ticket->id) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-blue-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-blue-300/50 hover:bg-blue-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                            aria-label="Edit {{ $ticket->ticket_number }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('repair-tickets.destroy', $ticket->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure to delete this ticket {{ $ticket->ticket_number }}?')"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-400/20 bg-red-500/10 text-red-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-red-300/50 hover:bg-red-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                                aria-label="Delete {{ $ticket->ticket_number }}">
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
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white/5 text-gray-400 ring-1 ring-white/10">
                                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v2h14V5a2 2 0 00-2-2H5zm12 6H3v6a2 2 0 002 2h10a2 2 0 002-2V9zm-9 2a1 1 0 100 2h4a1 1 0 100-2H8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-white">No tickets found</h3>
                                        <p class="mt-1 text-sm text-gray-400">Create a ticket or adjust the filters to see results.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($tickets->hasPages())
            <div class="mt-5 flex flex-col gap-4 rounded-xl border border-white/10 bg-gray-800/70 px-4 py-3 text-sm text-gray-300 shadow-lg shadow-black/10 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    Showing
                    <span class="font-semibold text-white">{{ $tickets->firstItem() }}</span>
                    to
                    <span class="font-semibold text-white">{{ $tickets->lastItem() }}</span>
                    of
                    <span class="font-semibold text-white">{{ $tickets->total() }}</span>
                    results
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($tickets->onFirstPage())
                        <span class="rounded-lg border border-white/10 px-3 py-2 text-gray-500 cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $tickets->previousPageUrl() }}" class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">Previous</a>
                    @endif

                    @foreach ($tickets->getUrlRange(1, $tickets->lastPage()) as $page => $url)
                        @if ($page == $tickets->currentPage())
                            <span class="rounded-lg bg-blue-600 px-3 py-2 font-semibold text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($tickets->hasMorePages())
                        <a href="{{ $tickets->nextPageUrl() }}" class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">Next</a>
                    @else
                        <span class="rounded-lg border border-white/10 px-3 py-2 text-gray-500 cursor-not-allowed">Next</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
