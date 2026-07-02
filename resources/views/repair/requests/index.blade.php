@extends('layouts.admin')

@section('content')


    <div class="flex items-center gap-3 mb-6">
        <div class="p-3 rounded-xl bg-blue-500/10 border border-blue-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                class="w-7 h-7 text-blue-400">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2Z" />
            </svg>
        </div>

        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">
                Repair Requests
            </h1>

            <p class="text-sm text-gray-400">
                Manage and review incoming repair requests
            </p>
        </div>
    </div>


    @if (session('success') || session('updated') || session('deleted'))
        <div @class([
            'p-3 mx-2 my-5 rounded',
            'bg-green-100 text-green-700' => session('success'),
            'bg-yellow-100 text-yellow-700' => session('updated'),
            'bg-red-100 text-red-700' => session('deleted'),
        ])>
            {{ session('success') ?? (session('updated') ?? session('deleted')) }}
        </div>
    @endif

    <div
        class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default text-white mt-5">

        {{--  Table --}}
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        ID
                    </th>

                    <th scope="col" class="px-6 py-3 font-medium">
                        Customer
                    </th>

                    <th scope="col" class="px-6 py-3 font-medium">
                        Issue Description
                    </th>



                    <th scope="col" class="px-6 py-3 font-medium">
                        Status
                    </th>

                    <th scope="col" class="px-6 py-3 font-medium">
                        Received at
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Action
                    </th>

                </tr>
            </thead>
            <tbody>

                @foreach ($repair_requests as $repair_request)
                    @php
                        $repair_request_id = $repair_request->id;
                        $converted_ticket_id = $repair_request->converted_ticket_id;
                        $status = $repair_request->status;
                        $repair_request_created_at = $repair_request->created_at->diffForHumans();
                        $repair_request = json_decode($repair_request['data']);
                    @endphp


                    <tr class="bg-neutral-primary border-b border-default">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $repair_request_id }}
                        </th>

                        <td class="px-6 py-4">
                            <span title="{{ $repair_request->phone }}">
                                {{ $repair_request->fullname }}

                            </span>
                        </td>

                        <td class="px-6 py-4">
                            {{ substr($repair_request->issue_description, 0, 50) }}...
                        </td>


                        <td class="px-6 py-4">
                            <x-status-badge :status="$status" />
                        </td>

                        <td class="px-6 py-4">
                            <span>
                                {{ $repair_request_created_at }}
                            </span>
                        </td>

                        <td class="px-6 py-4">

                            @if ($status == \App\Enums\RepairRequestStatus::pending->value)
                                <a href="{{ route('repair-requests.show', $repair_request_id) }}" title="review"
                                    class="inline-flex items-center justify-center rounded-md bg-green-500 p-2 text-white hover:bg-red-600 transition">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5" />
                                    </svg>
                                </a>
                            @endif



                            @if ($converted_ticket_id !== null && $status === \App\Enums\RepairRequestStatus::approved->value)
                                <a href="{{ route('repair-tickets.show', $converted_ticket_id) }}" title="details"
                                    class="inline-flex items-center justify-center rounded-md bg-blue-500 p-2 text-white hover:bg-red-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                    </svg>

                                </a>
                            @endif


                            @if ($status === \App\Enums\RepairRequestStatus::rejected->value)
                                <a href="{{ route('repair-requests.show', $repair_request_id) }}"  title="details"
                                    class="inline-flex items-center justify-center rounded-md bg-purple-500 p-2 text-white hover:bg-red-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                </a>
                            @endif



                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{--  Pagaination : --}}

    @if ($repair_requests->hasPages())
        <div
            class="mt-5 flex items-center text-white justify-between rounded-lg border border-default bg-neutral-primary-soft px-4 py-3 text-sm text-body">
            <div>
                Showing
                <span class="font-semibold text-heading">{{ $repair_requests->firstItem() }}</span>
                to
                <span class="font-semibold text-heading">{{ $repair_requests->lastItem() }}</span>
                of
                <span class="font-semibold text-heading">{{ $repair_requests->total() }}</span>
                results
            </div>

            <div class="flex items-center gap-2">
                @if ($repair_requests->onFirstPage())
                    <span class="rounded-md border border-default px-3 py-2 text-gray-400 cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $repair_requests->previousPageUrl() }}"
                        class="rounded-md border border-default px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Previous
                    </a>
                @endif

                @foreach ($repair_requests->getUrlRange(1, $repair_requests->lastPage()) as $page => $url)
                    @if ($page == $repair_requests->currentPage())
                        <span class="rounded-md bg-red-500 px-3 py-2 text-white">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="rounded-md border border-default px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if ($repair_requests->hasMorePages())
                    <a href="{{ $repair_requests->nextPageUrl() }}"
                        class="rounded-md border border-default px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Next
                    </a>
                @else
                    <span class="rounded-md border border-default px-3 py-2 text-gray-400 cursor-not-allowed">
                        Next
                    </span>
                @endif
            </div>
        </div>
    @endif
@endsection
