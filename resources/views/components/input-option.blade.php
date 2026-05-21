@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => ''
])

<div class="mt-2">
    <input :id="'attribute_' + item" x-model="arr[item]" x-effect=" console.log(arr) " value="{{ old('value', '') }}"
        type="text" :name="'attributes[' + item + ']'" autocomplete="given-value"
        class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
    <button type="button" @click=" decrement(item) "
        class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        -
    </button>
    @error('value')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>






<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>

    <input  type="{{ $type }}"
            name="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror"
            id="{{ $name }}"
            value="{{ old($name, $value)}}"
    />

    @error($name)
        <div class="invalid-feedback">{{ $message}}</div>
    @enderror

</div>
