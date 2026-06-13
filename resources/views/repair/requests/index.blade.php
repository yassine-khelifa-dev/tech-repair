@extends('layouts.admin')

@section('content')
    <h1 class="text-white my-2">Page Repair Requests :</h1>

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
                            <span title="   {{ $repair_request->status }} ">
                                {{ $repair_request->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <span>
                                {{ $repair_request_created_at }}
                            </span>
                        </td>



                        <td class="px-6 py-4">

                            <a href="{{ route('repair-requests.show', $repair_request_id) }}"
                                class="inline-flex items-center justify-center rounded-md bg-green-500 p-2 text-white hover:bg-red-600 transition">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5" />
                                </svg>

                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
