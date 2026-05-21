@extends('layouts.admin')

@section('content')
    <h1 class="text-white my-2">Page Attribute & Options :</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 mx-2 my-5 rounded">
        {{ session('success') }}
    </div>
@endif

 <a href="{{  route('spec-attribute.create') }}" class="rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
    Create New Attr </a>


<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default text-white mt-5">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
            <tr>


                <th scope="col" class="px-6 py-3 font-medium">
                    Type
                </th>

                <th scope="col" class="px-6 py-3 font-medium">
                    Device Attribute Name
                </th>

                 <th scope="col" class="px-6 py-3 font-medium">
                    Device Attribute Code
                </th>


                <th scope="col" class="px-6 py-3 font-medium">
                    Input Type
                </th>


                 <th scope="col" class="px-6 py-3 font-medium">
                    Sort Order
                </th>

                 <th scope="col" class="px-6 py-3 font-medium">
                    Filterable
                </th>


                 <th scope="col" class="px-6 py-3 font-medium">
                    Required
                </th>


                <th scope="col" class="px-6 py-3 font-medium">
                    Date
                </th>
                 <th scope="col" class="px-6 py-3 font-medium">
                    Action
                </th>

            </tr>
        </thead>
        <tbody>







        </tbody>
    </table>
</div>







@endsection
