@extends('layouts.admin')

@section('content')
    @include('repair.tickets._form', [
        'mode' => 'edit',
        'action' => route('repair-tickets.update', $repair_ticket->id),
        'method' => 'PUT',
    ])
@endsection
