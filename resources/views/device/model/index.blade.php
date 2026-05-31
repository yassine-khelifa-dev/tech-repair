@extends('layouts.admin')

@section('content')
    <div x-data='{modal:  false,
              model_selected: null}'>

        <div x-cloak x-show="modal" x-transition @click.self="modal = false" @keydown.escape.window="modal = false"
            class="fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 backdrop-blur-sm">
            @include('device.model._modal-show')
        </div>



        <h1 class="text-white my-2">Page Device Model :</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 mx-2 my-5 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('devicemodel.create') }}"
            class="rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
            Create New Device Model </a>




        <div
            class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default text-white mt-5">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Brand
                        </th>

                        <th scope="col" class="px-6 py-3 font-medium">
                            Type
                        </th>

                        <th scope="col" class="px-6 py-3 font-medium">
                            Device Model name
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


                    @foreach ($devicemodels as $devicemodel)
                        <tr class="bg-neutral-primary border-b border-default">

                            <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                {{ $devicemodel->brand->name }}
                            </th>

                            <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                {{ $devicemodel->type->name ?? 'none' }}
                            </th>


                            <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                {{ $devicemodel->name }}
                            </th>


                            <td class="px-6 py-4">
                                {{ $devicemodel->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">


                                <a href="{{ route('device-model-configuration.edit', $devicemodel->id) }}"
                                    class="inline-flex items-center justify-center rounded-md bg-purple-500 p-2 text-white hover:bg-red-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                                    </svg>

                                </a>

                                <button @click="modal = true; model_selected = {{ Js::from($devicemodel) }}" type="button"
                                    class="rounded-md bg-green-600 px-3 py-2 text-sm mt-2 font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                                    </svg>

                                </button>

                                <a href="{{ route('devicemodel.edit', $devicemodel->id) }}"
                                    class="inline-flex items-center justify-center rounded-md bg-blue-500 p-2 text-white hover:bg-red-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>

                                </a>

                                <form action="{{ route('devicemodel.destroy', $devicemodel->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure to delete this device model? ') "
                                        class="rounded-md bg-red-500 px-3 py-2 text-sm mt-2 font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>



                                    </button>



                                </form>

                            </td>

                        </tr>
                    @endforeach




                </tbody>
            </table>
        </div>

        @if ($devicemodels->hasPages())
            <div
                class="mt-5 flex items-center justify-between text-white rounded-lg border border-default bg-neutral-primary-soft px-4 py-3 text-sm text-body">

                <div>
                    Showing
                    <span class="font-semibold text-heading">{{ $devicemodels->firstItem() }}</span>
                    to
                    <span class="font-semibold text-heading">{{ $devicemodels->lastItem() }}</span>
                    of
                    <span class="font-semibold text-heading">{{ $devicemodels->total() }}</span>
                    results
                </div>

                <div class="flex items-center gap-2">
                    @if ($devicemodels->onFirstPage())
                        <span class="rounded-md border border-default px-3 py-2 text-gray-400 cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="{{ $devicemodels->previousPageUrl() }}"
                            class="rounded-md border border-default px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Previous
                        </a>
                    @endif

                    @foreach ($devicemodels->getUrlRange(1, $devicemodels->lastPage()) as $page => $url)
                        @if ($page == $devicemodels->currentPage())
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

                    @if ($devicemodels->hasMorePages())
                        <a href="{{ $devicemodels->nextPageUrl() }}"
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



















    </div>
@endsection
