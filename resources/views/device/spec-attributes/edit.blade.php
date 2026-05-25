@extends('layouts.admin')

@section('content')
    @include('device.spec-attributes._form', [
        'mode' => 'edit',
        'action' => route('spec-attribute.update', $spec_attribute->id),
        'method' => 'PUT',
        'spec_attribute' => $spec_attribute,
        'selectedDeviceTypes' => $spec_attribute->deviceTypes->pluck('id')->toArray(),
        'specOptions' => $spec_attribute->specOptions->pluck('value'),
    ])
@endsection
