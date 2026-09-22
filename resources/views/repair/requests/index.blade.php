@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-blue-400/20 bg-blue-500/10 text-blue-300 shadow-lg shadow-blue-900/20">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                </svg>
            </div>

            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Repair center</p>
                <h1 class="mt-1 text-3xl font-bold text-white">Repair Requests</h1>
                <p class="mt-1 text-sm text-gray-400">Review incoming requests and convert approved work into tickets.</p>
            </div>
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
                    Repair requests are customer submissions before they become repair tickets. Review a pending request to accept or reject it. When a request is approved and converted, use Open Ticket to continue the repair workflow.
                </p>
            </div>

            <div class="grid gap-2 text-sm text-gray-300 sm:grid-cols-3 md:grid-cols-1">
                <div class="rounded-lg border border-white/10 bg-gray-950/30 px-3 py-2">
                    <span class="font-semibold text-emerald-200">Review</span> accepts or rejects a pending request.
                </div>
                <div class="rounded-lg border border-white/10 bg-gray-950/30 px-3 py-2">
                    <span class="font-semibold text-blue-200">Open Ticket</span> opens the created ticket.
                </div>
                <div class="rounded-lg border border-white/10 bg-gray-950/30 px-3 py-2">
                    <span class="font-semibold text-purple-200">Details</span> opens a rejected request.
                </div>
            </div>
        </div>

        @include('repair.partials._filters', [
            'action' => route('repair-requests.index'),
            'status' => \App\Enums\RepairRequestStatus::cases(),
        ])

        <div class="mt-5 overflow-hidden rounded-xl border border-white/10 bg-gray-800/70 shadow-2xl shadow-black/20">
            <div class="border-b border-white/10 px-5 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-base font-semibold text-white">Request list</h2>
                        <p class="mt-1 text-sm text-gray-400">{{ $repair_requests->total() }} total requests</p>
                    </div>
                    <div class="hidden rounded-lg bg-blue-500/10 px-3 py-2 text-sm font-semibold text-blue-200 sm:block">
                        {{ $repair_requests->count() }} on this page
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-900/60 text-xs uppercase tracking-wide text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Request</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Customer</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Issue</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Created</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($repair_requests as $repair_request)
                            @php
                                $repair_request_id = $repair_request->id;
                                $converted_ticket_id = $repair_request->converted_ticket_id;
                                $status = $repair_request->status;
                                $repair_request_created_at = $repair_request->created_at->diffForHumans();
                                $issue = $repair_request->data['issue_description'] ?? '';
                            @endphp

                            <tr class="group transition-colors duration-200 hover:bg-white/[.04]">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/10 text-blue-300 ring-1 ring-blue-400/20 transition-transform duration-200 group-hover:scale-105">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M2.94 6.34A2 2 0 014.77 5h10.46a2 2 0 011.83 1.34L10 10.77 2.94 6.34z" />
                                                <path d="M18 8.12V14a2 2 0 01-2 2H4a2 2 0 01-2-2V8.12l7.47 4.68a1 1 0 001.06 0L18 8.12z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-white">Request #{{ $repair_request_id }}</div>
                                            @if ($converted_ticket_id)
                                                <div class="mt-1 text-xs text-gray-500">Ticket #{{ $converted_ticket_id }}</div>
                                            @else
                                                <div class="mt-1 text-xs text-gray-500">Not converted</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-200">{{ $repair_request->fullname }}</div>
                                    <div class="mt-1 text-xs text-gray-500">{{ $repair_request->phone }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="max-w-md truncate text-gray-300" title="{{ $issue }}">
                                        {{ \Illuminate\Support\Str::limit($issue, 70) }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    <x-status-badge :status="$status" />
                                </td>

                                <td class="px-6 py-4 text-gray-300">
                                    {{ $repair_request_created_at }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        @if ($status == \App\Enums\RepairRequestStatus::pending->value)
                                            <a href="{{ route('repair-requests.show', $repair_request_id) }}"
                                                title="Open review page to accept or reject this request"
                                                class="inline-flex min-w-24 items-center justify-center gap-1.5 rounded-lg border border-emerald-400/20 bg-emerald-500/10 px-3 py-2 text-xs font-semibold text-emerald-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300/50 hover:bg-emerald-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                                aria-label="Review request #{{ $repair_request_id }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM8.288 14.212A5.25 5.25 0 1117.25 10.5" />
                                                </svg>
                                                Review
                                            </a>
                                        @endif

                                        @if ($converted_ticket_id !== null && $status === \App\Enums\RepairRequestStatus::approved->value)
                                            <a href="{{ route('repair-tickets.show', $converted_ticket_id) }}"
                                                title="Open the repair ticket created from this approved request"
                                                class="inline-flex min-w-28 items-center justify-center gap-1.5 rounded-lg border border-blue-400/20 bg-blue-500/10 px-3 py-2 text-xs font-semibold text-blue-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-blue-300/50 hover:bg-blue-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                                aria-label="Open converted ticket #{{ $converted_ticket_id }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                                </svg>
                                                Open Ticket
                                            </a>
                                        @endif

                                        @if ($status === \App\Enums\RepairRequestStatus::rejected->value)
                                            <a href="{{ route('repair-requests.show', $repair_request_id) }}"
                                                title="Open this rejected request to see its original details"
                                                class="inline-flex min-w-24 items-center justify-center gap-1.5 rounded-lg border border-purple-400/20 bg-purple-500/10 px-3 py-2 text-xs font-semibold text-purple-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-purple-300/50 hover:bg-purple-500/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                                                aria-label="Open rejected request #{{ $repair_request_id }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632A2.25 2.25 0 0117.378 20.25H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25" />
                                                </svg>
                                                Details
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white/5 text-gray-400 ring-1 ring-white/10">
                                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M2.94 6.34A2 2 0 014.77 5h10.46a2 2 0 011.83 1.34L10 10.77 2.94 6.34z" />
                                                <path d="M18 8.12V14a2 2 0 01-2 2H4a2 2 0 01-2-2V8.12l7.47 4.68a1 1 0 001.06 0L18 8.12z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-white">No requests found</h3>
                                        <p class="mt-1 text-sm text-gray-400">Adjust the filters or wait for new customer requests.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($repair_requests->hasPages())
            <div class="mt-5 flex flex-col gap-4 rounded-xl border border-white/10 bg-gray-800/70 px-4 py-3 text-sm text-gray-300 shadow-lg shadow-black/10 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    Showing
                    <span class="font-semibold text-white">{{ $repair_requests->firstItem() }}</span>
                    to
                    <span class="font-semibold text-white">{{ $repair_requests->lastItem() }}</span>
                    of
                    <span class="font-semibold text-white">{{ $repair_requests->total() }}</span>
                    results
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($repair_requests->onFirstPage())
                        <span class="rounded-lg border border-white/10 px-3 py-2 text-gray-500 cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $repair_requests->previousPageUrl() }}" class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">Previous</a>
                    @endif

                    @foreach ($repair_requests->getUrlRange(1, $repair_requests->lastPage()) as $page => $url)
                        @if ($page == $repair_requests->currentPage())
                            <span class="rounded-lg bg-blue-600 px-3 py-2 font-semibold text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($repair_requests->hasMorePages())
                        <a href="{{ $repair_requests->nextPageUrl() }}" class="rounded-lg border border-white/10 px-3 py-2 transition hover:border-blue-300/50 hover:bg-blue-500/10 hover:text-white">Next</a>
                    @else
                        <span class="rounded-lg border border-white/10 px-3 py-2 text-gray-500 cursor-not-allowed">Next</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
