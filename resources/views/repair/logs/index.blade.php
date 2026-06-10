<section class="mt-6 rounded-xl border border-gray-700 bg-gray-800 p-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-white">
                Repair Activity
            </h2>
            <p class="mt-1 text-sm text-gray-400">
                Technical notes and status changes for this ticket.
            </p>
        </div>

        <span class="rounded-full bg-gray-700 px-3 py-1 text-sm text-gray-300">
            {{ $logs->count() }} logs
        </span>
    </div>

    @forelse ($logs as $log)
    
        <article class="border-b border-gray-700 py-5 last:border-b-0">
            <div class="mb-3 flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold text-white">
                            T
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-white">
                                Technician
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $log->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>



                @if ($log->is_visible_to_customer)
                    <span
                        class="rounded-full border border-green-500/30 bg-green-500/10 px-3 py-1 text-xs font-medium text-green-300">
                        Visible to customer
                    </span>
                @elseif(auth()->user())
                    <span
                        class="rounded-full border border-gray-500/30 bg-gray-700 px-3 py-1 text-xs font-medium text-gray-300">
                        Internal only
                    </span>
                @endif
            </div>

            <p class="mb-3 whitespace-pre-line text-sm leading-6 text-gray-200">
                {{ $log->message }}
            </p>

            @if ($log->old_status || $log->new_status)
                <div class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-3 py-2 text-xs text-gray-300">
                    <span class="text-gray-400">Status:</span>

                    <span class="font-medium text-yellow-300">
                        {{ $log->old_status ?? '-' }}
                    </span>

                    <span class="text-gray-500">→</span>

                    <span class="font-medium text-green-300">
                        {{ $log->new_status ?? '-' }}
                    </span>
                </div>
            @endif

            @if ($log->is_visible_to_customer)
                <div>

                    @include('repair.logs._images', [
                        'images' => $log->images,
                    ])
                </div>
            @elseif(auth()->user())
                <div>

                    @include('repair.logs._images', [
                        'images' => $log->images,
                    ])
                </div>
            @endif



        </article>
    @empty
        <div class="rounded-lg border border-dashed border-gray-600 p-6 text-center">
            <p class="text-sm text-gray-400">
                No activity has been added yet.
            </p>
        </div>
    @endforelse
</section>
