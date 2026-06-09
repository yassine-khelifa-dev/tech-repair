<div class="text-white">
    <h1 class="text-white">Images {{ $images->count() }}</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse ($images as $image)
            <div>
                <img class="h-auto max-w-full rounded-base" src="{{ Storage::url($image->path) }}" alt=""
                    class="w-32 h-32 object-cover rounded-lg" />
            </div>

        @empty
            <p>Does not have any image.</p>
        @endforelse
    </div>
</div>
