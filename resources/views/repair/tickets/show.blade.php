@extends('layouts.admin')
@section('content')
    <h1 class="text-white my-2">Page Repair Ticket :</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 mx-2 my-5 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="text-white">
        <h1> ticket number: {{ $repair_ticket->ticket_number }}</h1>
        <h1> customer: {{ $repair_ticket->customer->fullname }}</h1>

    </div>
@endsection
