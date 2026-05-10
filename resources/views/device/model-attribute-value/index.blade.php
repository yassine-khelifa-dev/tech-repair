@extends('layouts.admin')

@section('content')
    <h1 class="text-white my-2">Page Attribute value :</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 mx-2 my-5 rounded">
        {{ session('success') }}
    </div>
@endif



 <a href="{{  route('brand.create') }}" class="rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
    Create New Attr value </a>




@endsection
