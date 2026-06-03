@extends('layouts.admin')

@section('content')
    @include('repair.tickets._form', [
        'mode' => 'create',
        'action' => route('repair-tickets.store'),
        'method' => 'POST',
    ])
@endsection
