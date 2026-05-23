@props([
    'name',
    'label',
])

<label for="{{ $name }}"
    class="flex cursor-pointer items-start gap-3 rounded-lg border border-white/10 bg-white/5 p-4 text-white hover:bg-white/10">
    <input id="{{ $name }}" name="{{ $name }}" type="checkbox" value="1"
        class="mt-1 h-4 w-4 rounded border-white/20 bg-gray-900 text-indigo-500 focus:ring-indigo-500">
    <span>
        <span class="block text-sm font-medium"> {{ $label }} </span>
        <span class="block text-xs text-gray-400">
            User must provide this value when creating a device.
        </span>
    </span>
</label>
