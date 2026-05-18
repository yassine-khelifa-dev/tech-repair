@extends('layouts.admin')

@section('content')
    <h1 class="text-white my-2">Page Attribute :</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 mx-2 my-5 rounded">
        {{ session('success') }}
    </div>
@endif

 <a href="{{  route('device-attribute.create') }}" class="rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
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


             @foreach ($device_attributes as $device_attribute)
                <tr class="bg-neutral-primary border-b border-default">



                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{  $device_attribute->type->name  ?? 'none'}}
                    </th>


                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{  $device_attribute->name }}
                    </th>

                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{  $device_attribute->code }}
                    </th>

                     <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{  $device_attribute->input_type }}
                    </th>



                     <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{  $device_attribute->sort_order }}
                    </th>

                     <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{  $device_attribute->is_filterable  == 1 ? 'Yes' : 'Non' }}
                    </th>


                     <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{  $device_attribute->is_required == 1 ? 'Yes' : 'Non' }}
                    </th>


                     <td class="px-6 py-4">
                         {{  $device_attribute->created_at->diffForHumans() }}
                    </td>
                     <td class="px-6 py-4">
                      <a href="{{ route('device-attribute.edit', $device_attribute->id) }}"
                            class="inline-flex items-center justify-center rounded-md bg-red-500 p-2 text-white hover:bg-red-600 transition">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>

                       <form action="{{  route('device-attribute.destroy',    $device_attribute->id ) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to delete this device attribute? ') " class="rounded-md bg-orange-500 px-3 py-2 text-sm mt-2 font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>


                        </button>



                       </form>

                    </td>

                </tr>
            @endforeach




        </tbody>
    </table>
</div>


@if ($device_attributes->hasPages())
    <div class="mt-5 flex items-center justify-between text-white rounded-lg border border-default bg-neutral-primary-soft px-4 py-3 text-sm text-body">

        <div>
            Showing
            <span class="font-semibold text-heading">{{ $device_attributes->firstItem() }}</span>
            to
            <span class="font-semibold text-heading">{{ $device_attributes->lastItem() }}</span>
            of
            <span class="font-semibold text-heading">{{ $device_attributes->total() }}</span>
            results
        </div>

        <div class="flex items-center gap-2">
            @if ($device_attributes->onFirstPage())
                <span class="rounded-md border border-default px-3 py-2 text-gray-400 cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $device_attributes->previousPageUrl() }}"
                   class="rounded-md border border-default px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Previous
                </a>
            @endif

            @foreach ($device_attributes->getUrlRange(1, $device_attributes->lastPage()) as $page => $url)
                @if ($page == $device_attributes->currentPage())
                    <span class="rounded-md bg-red-500 px-3 py-2 text-white">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       class="rounded-md border border-default px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            @if ($device_attributes->hasMorePages())
                <a href="{{ $device_attributes->nextPageUrl() }}"
                   class="rounded-md border border-default px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Next
                </a>
            @else
                <span class="rounded-md border border-default px-3 py-2 text-gray-400 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
    </div>
@endif




@endsection
