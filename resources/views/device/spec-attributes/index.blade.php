@extends('layouts.admin')

@section('content')
    <h1 class="text-white my-2">Page Attribute & Options :</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 mx-2 my-5 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('spec-attribute.create') }}"
        class="rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
        Create New Attr </a>

    <div x-data='{modal:  false,
              model_selected: null}'
        class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default text-white mt-5">
        <table class="w-full text-sm text-left rtl:text-right text-body">

            <div x-cloak x-show="modal" x-transition @click.self="modal = false" @keydown.escape.window="modal = false"
                class="fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 backdrop-blur-sm">
                @include('device.spec-attributes._modal-detail')
            </div>


            <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                <tr>


                    <th scope="col" class="px-6 py-3 font-medium">
                        Types
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
                        Options
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




                @foreach ($spc_attributes as $spc_attribute)
                    <tr class="bg-neutral-primary border-b border-default">

                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            <div class="flex flex-col gap-2">

                                @foreach ($spc_attribute->deviceTypes->take(3) as $deviceType)
                                    <span
                                        class="inline-flex w-fit items-center gap-1 rounded-full border border-indigo-500/20 bg-indigo-500/10 px-3 py-1 text-xs font-medium text-indigo-300">
                                        {{ $deviceType->name }}
                                    </span>
                                @endforeach

                                @if ($spc_attribute->deviceTypes->count() > 3)
                                    <button @click="modal = true; model_selected = {{ Js::from($spc_attribute) }} "
                                        class="text-xs font-medium text-gray-400">
                                        +{{ $spc_attribute->deviceTypes->count() - 3 }}
                                        more...
                                    </button>
                                @endif

                            </div>
                        </th>


                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $spc_attribute->name }}
                        </th>

                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $spc_attribute->code }}
                        </th>

                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $spc_attribute->input_type }}
                        </th>


                        <th>
                            <ul>
                                @foreach ($spc_attribute->specOptions->take(3) as $option)
                                    <li class="flex items-center gap-2 text-sm text-gray-300">

                                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                                        <span>
                                            {{ $option->label }}

                                            {{ $spc_attribute->unit !== 'None' ? $spc_attribute->unit : '' }}
                                        </span>

                                    </li>
                                @endforeach
                                @if ($spc_attribute->specOptions->count() > 3)
                                    <button @click="modal = true; model_selected = {{ Js::from($spc_attribute) }} "
                                        class="pl-4 text-xs font-medium text-indigo-400">
                                        +{{ $spc_attribute->specOptions->count() - 3 }}
                                        more...
                                    </button>
                                @endif

                            </ul>

                        </th>


                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $spc_attribute->sort_order }}
                        </th>

                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $spc_attribute->is_filterable == 1 ? 'Yes' : 'Non' }}
                        </th>


                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $spc_attribute->is_required == 1 ? 'Yes' : 'Non' }}
                        </th>


                        <td class="px-6 py-4">
                            {{ $spc_attribute->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">

                                {{-- Show --}}
                                <button type="button" @click='modal = true; model_selected = @json($spc_attribute)'
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-blue-500 text-white transition hover:bg-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-4 w-4">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>

                                {{-- Edit --}}
                                <a href="{{ route('spec-attribute.edit', $spc_attribute->id) }}"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-indigo-500 text-white transition hover:bg-indigo-600">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-4 w-4">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('spec-attribute.destroy', $spc_attribute->id) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Are you sure to delete this attribute?')"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-red-500 text-white transition hover:bg-red-600">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-4 w-4">

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>
                @endforeach







            </tbody>
        </table>
    </div>
@endsection
