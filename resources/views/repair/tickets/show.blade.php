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
            @include('repair.partials._customer-info')

            {{-- Device Information --}}
            @include('repair.partials._device-info')

            {{-- Repair Details --}}
            @include('repair.partials._repair-details')

        </div>
    </div>
@endsection
