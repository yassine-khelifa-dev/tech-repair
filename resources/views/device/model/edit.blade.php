@extends('layouts.admin')

@section('content')

<form action="{{  route('devicemodel.update', $devicemodel->id) }}" method="post">
    @csrf
    @method('PUT')
    
  <div class="space-y-12">


 <div class="border-b border-white/10 pb-12">
    <h2 class="text-base/7 font-semibold text-white">Edit  a device Model</h2>
    <p class="mt-1 text-sm/6 text-gray-400">Use a permanent address where you can receive mail.</p>


     @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 mx-2 my-5 rounded">
            {{ session('success') }}
        </div>
    @endif


    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-3">
            <div class="sm:col-span-3">
            <label for="name" class="block text-sm/6 font-medium text-white">Name</label>
                <div class="mt-2">
                    <input id="name"
                        value="{{ old('name', $devicemodel->name) }}"
                    type="text" name="name" autocomplete="given-name" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-5 text-white">
            <label for="brand_id"
                class="mb-2.5 block text-sm font-medium text-white">
                Select a Brand
            </label>

            <select id="brand_id"
                    name="brand_id"
                    class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">

                <option class="bg-black text-white" value="{{  null }}" selected>
                    Choose a brand
                </option>

                @foreach ($brands as $brand)
                    <option class="bg-black text-white"
                            value="{{ $brand->id }}" {{ old('brand_id', $devicemodel->brand_id) == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach



            </select>
            @error('brand_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
            @enderror
        </div>


        <div class="mt-5 text-white">

            <label for="type_id"
                class="mb-2.5 block text-sm font-medium text-white">
                Select a Device Type
            </label>
            <select id="type_id"
                    name="type_id"
                    class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">

                <option class="bg-black text-white" value="{{  null }}" selected>
                    Choose a type
                </option>
                @foreach ($devicetypes as $devicetype)

                    <option class="bg-black text-white"
                            value="{{ $devicetype->id }}" {{ old('type_id', $devicemodel->type_id) == $devicetype->id ? 'selected' : '' }} >

                        {{ $devicetype->name }}

                    </option>
                @endforeach


            </select>
            @error('type_id')
                 <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
            @enderror
        </div>


    </div>

</div>
<div class="mt-6 flex items-center justify-end gap-x-6">
<a  href="{{  route('devicemodel.index') }}" type="button" class="text-sm/6 font-semibold text-white">Cancel</a>

<button value="save"   name="action"     type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Edit</button>

</div>

</form>


@endsection
