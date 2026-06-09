@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-white">
                    Repair Ticket Details
                </h1>
                <p class="text-gray-400">
                    Ticket #{{ $repair_ticket->ticket_number }}
                </p>
            </div>
            <a href="{{ route('repair-tickets.index') }}" class="px-4 py-2 rounded bg-blue-500 hover:bg-red-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 border border-green-300 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Customer Information --}}
            <div class="bg-gray-900 rounded-xl p-6 shadow">
                <h2 class="text-lg font-semibold text-white mb-4">
                    Customer Information
                </h2>

                <div class="space-y-3 text-gray-300">
                    <p>
                        <span class="font-medium text-white">Full Name:</span>
                        {{ $repair_ticket->customer->fullname }}
                    </p>

                    <p>
                        <span class="font-medium text-white">Phone:</span>
                        {{ $repair_ticket->customer->phone }}
                    </p>

                    <p>
                        <span class="font-medium text-white">Email:</span>
                        {{ $repair_ticket->customer->email ?: '-' }}
                    </p>
                </div>
            </div>

            {{-- Device Information --}}
            <div class="bg-gray-900 rounded-xl p-6 shadow">
                <h2 class="text-lg font-semibold text-white mb-4">
                    Device Information
                </h2>

                <div class="space-y-3 text-gray-300">
                    <p>
                        <span class="font-medium text-white">Brand:</span>
                        {{ $repair_ticket->deviceModel->brand->name }}
                    </p>

                    <p>
                        <span class="font-medium text-white">Model:</span>
                        {{ $repair_ticket->deviceModel->name }}
                    </p>

                    <p>
                        <span class="font-medium text-white">Serial Number:</span>
                        {{ $repair_ticket->sn ?: '-' }}
                    </p>
                </div>
            </div>

            {{-- Repair Details --}}
            <div class="bg-gray-900 rounded-xl p-6 shadow lg:col-span-2">
                <h2 class="text-lg font-semibold text-white mb-4">
                    Repair Details
                </h2>

                <div class="space-y-4 text-gray-300">

                    <div>
                        <p class="font-medium text-white mb-1">
                            Reported Issue
                        </p>
                        <p>
                            {{ $repair_ticket->issue_description ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="font-medium text-white mb-2">
                            Selected Options
                        </p>

                        <div class="flex flex-wrap gap-2">
                            @foreach ($repair_ticket->selectedOptions as $option)
                                <span class="px-3 py-1 rounded-full bg-blue-600/20 text-blue-300 border border-blue-500/30">
                                    {{ $option->specAttribute->name }} :
                                    {{ $option->value }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                </div>

                <hr class="mt-5 mb-2">

                <div>
                    @include('repair.logs.index', [
                        'logs' => $repair_ticket->logs,
                    ])
                </div>

                <hr class="mt-5 mb-2">

                <div>
                    @include('repair.logs._form')
                </div>
            </div>

        </div>
    </div>
@endsection
