@props(['name'])
@error($name)
    <div class="mt-1 text-sm text-red-400">{{ $message }}</div>
@enderror
