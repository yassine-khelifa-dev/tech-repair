@props([
    'name',
    'label',
    'type' => 'text',
    'model' => '',
])

<label for="{{ $name }}" class="block text-sm font-medium text-white">
    {{ $label }}
</label>
<input id="{{ $name }}" x-model="{{ $model }}" value="{{ old($name, '') }}" placeholder="{{ $label }}"
    type="{{ $type }}" name="{{ $name }}" autocomplete="{{ $label }}"
    class="mt-2 block w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" />
