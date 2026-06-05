@extends('layouts.admin')

@section('content')
    <h1 class="text-white my-2">Page Repair Ticket :</h1>

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

    <a href="{{ route('repair-tickets.create') }}"
        class="rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
        Create New Ticket </a>

    <div
        class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default text-white mt-5">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Ticket Number
                    </th>

                    <th scope="col" class="px-6 py-3 font-medium">
                        Customer
                    </th>

                    <th scope="col" class="px-6 py-3 font-medium">
                        Device Model
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

                @foreach ($tickets as $ticket)
                    <tr class="bg-neutral-primary border-b border-default">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $ticket->ticket_number }}
                        </th>

                        <td class="px-6 py-4">
                            <span title=" {{ $ticket->customer->phone }}">
                                {{ $ticket->customer->fullname }}

                            </span>
                        </td>

                        <td class="px-6 py-4">
                            {{ $ticket->deviceModel->brand->name }} - {{ $ticket->deviceModel->name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $ticket->status }}
                        </td>


                        <td class="px-6 py-4">
                            <span title=" {{ $ticket->received_at }} ">
                                {{ $ticket->received_at->diffForHumans() }}
                            </span>

                        </td>

                        <td class="px-6 py-4">
                            <a href="{{ route('repair-tickets.show', $ticket->id) }}"
                                class="inline-flex items-center justify-center rounded-md bg-green-500 p-2 text-white hover:bg-red-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                                </svg>
                            </a>
                            <a href="{{ route('repair-tickets.edit', $ticket->id) }}"
                                class="inline-flex items-center justify-center rounded-md bg-blue-500 p-2 text-white hover:bg-red-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                            <form action="{{ route('repair-tickets.destroy', $ticket->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure to delete this ticket {{ $ticket->ticket_number }}? ') "
                                    class="rounded-md bg-red-500 px-3 py-2 text-sm mt-2 font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>

    @if ($tickets->hasPages())
        <div
            class="mt-5 flex items-center text-white justify-between rounded-lg border border-default bg-neutral-primary-soft px-4 py-3 text-sm text-body">
            <div>
                Showing
                <span class="font-semibold text-heading">{{ $tickets->firstItem() }}</span>
                to
                <span class="font-semibold text-heading">{{ $tickets->lastItem() }}</span>
                of
                <span class="font-semibold text-heading">{{ $tickets->total() }}</span>
                results
            </div>

            <div class="flex items-center gap-2">
                @if ($tickets->onFirstPage())
                    <span class="rounded-md border border-default px-3 py-2 text-gray-400 cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $tickets->previousPageUrl() }}"
                        class="rounded-md border border-default px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Previous
                    </a>
                @endif

                @foreach ($tickets->getUrlRange(1, $tickets->lastPage()) as $page => $url)
                    @if ($page == $tickets->currentPage())
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

                @if ($tickets->hasMorePages())
                    <a href="{{ $tickets->nextPageUrl() }}"
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
