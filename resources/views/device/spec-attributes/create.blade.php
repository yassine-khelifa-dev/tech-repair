@extends('layouts.admin')

@section('content')
    @include('device.spec-attributes._form', [
        'mode' => 'create',
        'action' => route('spec-attribute.store'),
        'method' => 'POST',
        'spec_attribute' => null,
        'selectedDeviceTypes' =>  old('devicetypes', []),
        'specOptions' => [],
    ])
@endsection
