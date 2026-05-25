@props([
    'name',
    'label',
    'multiple' => false,
    'model'=> null
])

<label for="{{ $name }}" class="block text-sm font-medium text-white">
   {{$label}}
</label>
<select id="{{  $name }}" name="{{ $name }}"  {{  $multiple == 1 ? 'multiple' : '' }} @if($model) x-model="{{ $model }}" @endif
    class="mt-2 block w-full rounded-lg border border-white/10 bg-gray-950 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
   {{  $slot }}
</select>
