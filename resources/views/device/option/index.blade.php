@extends('layouts.admin')

@section('content')
    <h1 class="text-white my-2">Page Attribute-Option :</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 mx-2 my-5 rounded">
        {{ session('success') }}
    </div>
@endif

 <a href="{{  route('device-attribute-option.create') }}" class="rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
    Create New Option </a>


<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default text-white mt-5">

    <table class="w-full text-sm text-left rtl:text-right text-body">

        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
            <tr>
                <th class="px-6 py-3 font-medium">
                    Type - Attribute
                </th>

                <th class="px-6 py-3 font-medium">
                    Options
                </th>
            </tr>
        </thead>

        <tbody>

            @foreach ($attr_options as $group)

                @php
                    $firstOption = $group->first();
                    $attribute = $firstOption->deviceAttribute;
                @endphp

                <tr class="bg-neutral-primary border-b border-default">

                    <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{ $attribute->type->name ?? 'none' }}
                        -
                        {{ $attribute->name ?? 'none' }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">

                            @foreach ($group as $option)

                                <span class="inline-flex items-center rounded-md bg-gray-800 px-3 py-1 text-sm text-white border border-gray-700">
                                    {{ $option->value }}

                                  {{-- edit --}}
                                    <a href="{{ route('device-attribute-option.edit', $option->id) }}"
                                    class="text-blue-400 hover:text-blue-300">
                                        ✏️
                                    </a>

                                     {{-- delete --}}
                                    <form action="{{ route('device-attribute-option.destroy', $option->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('Delete this option?')"
                                                class="text-red-400 hover:text-red-300">

                                            🗑️

                                        </button>

                                    </form>
                                </span>



                            @endforeach

                        </div>
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>



@endsection
