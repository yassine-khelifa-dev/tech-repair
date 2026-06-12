<div x-data="{ open: false, imageUrl: '' }" class="text-white">
    <h1 class="text-white mb-3">
        {{ $title ?? 'Images' }}
        ({{ $images->count() }})
    </h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse ($images as $image)
            <div>
                <img src="{{ Storage::url($image->path) }}" alt="Image"
                    class="w-full h-40 object-cover rounded-lg cursor-pointer hover:opacity-80 transition"
                    @click="
                        imageUrl = '{{ Storage::url($image->path) }}';
                        open = true;
                    ">
            </div>
        @empty
            <p class="text-gray-400">
                Does not have any image.
            </p>
        @endforelse
    </div>

    {{-- Modal --}}
    <div x-show="open" x-transition.opacity @click.self="open = false" @keydown.escape.window="open = false"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 p-4" style="display: none;">
        <div class="relative">
            <button type="button" @click="open = false" class="absolute -top-12 right-0 text-white text-4xl">
                &times;
            </button>

            <img :src="imageUrl" alt="Preview" class="max-w-[90vw] max-h-[90vh] rounded-lg shadow-2xl">
        </div>
    </div>
</div>
