

@extends('layouts.admin')

@section('content')

<form action="{{  route('device-attribute-option.store') }}" method="POST">
    @csrf
  <div class="space-y-12">
    <div class="border-b border-white/10 pb-12">
        <h2 class="text-base/7 font-semibold text-white">Create Device Attribute Options</h2>
        <p class="mt-1 text-sm/6 text-gray-400">Define a dynamic attribute for a device type.</p>

         <div class="mt-5 text-white">

            <label for="device_attribute_id"
                class="mb-2.5 block text-sm font-medium text-white">
                Select a Device Attribute
            </label>
            <select id="device_attribute_id"
                    name="device_attribute_id"
                    class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">

                <option class="bg-black text-white" value="{{  null }}" selected>
                    Choose an attribute
                </option>
                @foreach ($deviceAttributes as $device_attribute)

                    <option class="bg-black text-white"
                            value="{{ $device_attribute->id }}" {{ old('device_attribute_id') == $device_attribute->id ? 'selected' : '' }} >

                        {{  $device_attribute->type->name . " - ".$device_attribute->name  }}

                    </option>
                @endforeach


            </select>
            @error('device_attribute_id')
                 <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
            @enderror
        </div>



        <div id="options-list" class="mt-4 flex flex-wrap gap-2 text-white bg-white m-2 p-3"></div>





        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-3">
            <div class="sm:col-span-3">
            <label for="value" class="block text-sm/6 font-medium text-white">Value</label>
                <div class="mt-2">
                    <input id="value"
                        value="{{ old('value', '') }}"
                    type="text" name="value" autocomplete="given-value" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    @error('value')
                        <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
                    @enderror
                </div>
            </div>
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

    <div class="mt-6 flex items-center justify-end gap-x-6">
         <a  href="{{  route('device-attribute-option.index') }}" type="button" class="text-sm/6 font-semibold text-white">Cancel</a>
         <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
    </div>
</form>
@endsection




@section('script')

<script>
    const attributes = @json($deviceAttributes);

    const select = document.getElementById('device_attribute_id');
    const optionsList = document.getElementById('options-list');

    select.addEventListener('change', function () {
        const selectedId = Number(this.value);

        optionsList.innerHTML = '';

        const attribute = attributes.find(item => item.id === selectedId);

        if (!attribute) {
            optionsList.innerHTML = '<span class="text-gray-400">No attribute selected</span>';
            return;
        }

        if (!attribute.options || attribute.options.length === 0) {
            optionsList.innerHTML = '<span class="text-gray-400">No options yet</span>';
            return;
        }

        attribute.options.forEach(option => {
            const badge = document.createElement('span');

            badge.className = 'rounded-md bg-gray-800 border border-gray-700 px-3 py-1 text-sm text-white';
            badge.textContent = option.value;

            optionsList.appendChild(badge);
        });
    });
</script>

@endsection
