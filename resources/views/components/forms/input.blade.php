@props(['name', 'label', 'type' => 'text', 'model' => '', 'value' => '', 'placeholder' => null])

<label for="{{ $name }}" class="block text-sm font-medium text-white">
    {{ $label }}
</label>
<input id="{{ $name }}"   value="{{ $value }}"
    placeholder="{{ $placeholder?? $name }}" type="{{ $type }}" name="{{ $name }}"
    autocomplete="{{ $label }}"
    @if($model) x-model="{{ $model }}"  @endif
    class="mt-2 block w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" />
