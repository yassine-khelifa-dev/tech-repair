

@extends('layouts.admin')

@section('content')

<form action="{{  route('device-attribute.store') }}" method="POST">
    @csrf
  <div class="space-y-12">


 <div class="border-b border-white/10 pb-12">
    <h2 class="text-base/7 font-semibold text-white">Create Device Attribute</h2>
    <p class="mt-1 text-sm/6 text-gray-400">Define a dynamic attribute for a device type.</p>


    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-3">


          <div class="mt-5 text-white">

            <label for="device_type_id"
                class="mb-2.5 block text-sm font-medium text-white">
                Select a Device Type
            </label>
            <select id="device_type_id"
                    name="device_type_id"
                    class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">

                <option class="bg-black text-white" value="{{  null }}" selected>
                    Choose a type
                </option>
                @foreach ($devicetypes as $devicetype)

                    <option class="bg-black text-white"
                            value="{{ $devicetype->id }}" {{ old('device_type_id') == $devicetype->id ? 'selected' : '' }} >

                        {{ $devicetype->name }}

                    </option>
                @endforeach


            </select>
            @error('device_type_id')
                 <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
            @enderror
        </div>









        <div class="sm:col-span-3">
            <label for="name" class="block text-sm/6 font-medium text-white">Attribute Name</label>
            <div class="mt-2">
                <input id="name"
                    value="{{ old('name', '') }}" placeholder="Storage"
                type="text" name="name" autocomplete="given-name" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
                @enderror
             </div>
        </div>


         <div class="sm:col-span-3">
            <label for="code" class="block text-sm/6 font-medium text-white">Technical Code (Unique internal identifier used by the system.)</label>
            <div class="mt-2">
                <input id="code"
                    value="{{ old('code') }}" placeholder="Storage"
                type="text" name="code" autocomplete="given-name" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                @error('code')
                    <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
                @enderror
             </div>
        </div>


         <div class="mt-5 text-white">

            <label for="input_type"
                class="mb-2.5 block text-sm font-medium text-white">
                Select a Device Type
            </label>
            <select id="input_type"
                    name="input_type"
                    class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">

                <option class="bg-black text-white" value="{{  null }}" selected>
                    Input Type
                </option>

                    <option class="bg-black text-white"value="text"   {{ old('input_type') == "text" ? 'selected' : '' }}>Text </option>
                    <option class="bg-black text-white"value="number"  {{ old('input_type') == "number" ? 'selected' : '' }}> Number</option>
                    <option class="bg-black text-white"value="select" {{ old('input_type') == "select" ? 'selected' : '' }} > Select</option>
                    <option class="bg-black text-white"value="boolean" {{ old('input_type') == "boolean" ? 'selected' : '' }} > Boolean</option>


            </select>
            @error('input_type')
                 <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
            @enderror
        </div>



        <div class="flex items-center mb-4 text-white">
            <input id="is_required" name="is_required" type="checkbox" value="1" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
            <label for="is_required" name="is_required" class="select-none ms-2 text-sm font-medium text-heading">Required Attribute</label>
        </div>


        <div class="flex items-center mb-4 text-white">
            <input id="is_filterable" name="is_filterable" type="checkbox" value="1" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
            <label for="is_filterable" name="is_filterable" class="select-none ms-2 text-sm font-medium text-heading">Filterable Attribute</label>
        </div>



         <div class="sm:col-span-3">
            <label for="sort_order" class="block text-sm/6 font-medium text-white">Sort Order (Controls the display position in forms..)</label>
            <div class="mt-2">
                <input id="sort_order"
                    value="{{ old('sort_order') }}" placeholder="1"
                type="text" name="sort_order" autocomplete="given-name" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                @error('sort_order')
                    <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
                @enderror
             </div>
        </div>


        </div>
    </div>
</div>
<div class="mt-6 flex items-center justify-end gap-x-6">
<a  href="{{  route('device-attribute.index') }}" type="button" class="text-sm/6 font-semibold text-white">Cancel</a>

<button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
</div>

</form>


@endsection
