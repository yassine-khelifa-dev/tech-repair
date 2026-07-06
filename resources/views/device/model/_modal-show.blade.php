<div class="w-full max-w-lg overflow-hidden rounded-xl border border-white/10 bg-gray-800 shadow-2xl shadow-black/40">
    <div class="border-b border-white/10 px-6 py-5">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-500/10 text-blue-300 ring-1 ring-blue-400/20">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Model details</p>
                    <h2 class="mt-1 text-xl font-bold text-white" x-text="model_selected?.name"></h2>
                </div>
            </div>

            <button @click="modal = false"
                class="rounded-lg p-2 text-gray-400 transition hover:bg-white/10 hover:text-white"
                type="button"
                aria-label="Close modal">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div class="px-6 py-5">
        <dl class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-lg border border-white/10 bg-white/[.04] p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">ID</dt>
                <dd class="mt-1 text-sm font-semibold text-white" x-text="model_selected?.id"></dd>
            </div>
            <div class="rounded-lg border border-white/10 bg-white/[.04] p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Created</dt>
                <dd class="mt-1 text-sm font-semibold text-white" x-text="model_selected?.created_at ? new Date(model_selected.created_at).toLocaleDateString() : '-'"></dd>
            </div>
            <div class="rounded-lg border border-white/10 bg-white/[.04] p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Brand</dt>
                <dd class="mt-1 text-sm font-semibold text-white" x-text="model_selected?.brand?.name ?? 'No brand'"></dd>
            </div>
            <div class="rounded-lg border border-white/10 bg-white/[.04] p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Type</dt>
                <dd class="mt-1 text-sm font-semibold text-white" x-text="model_selected?.type?.name ?? 'No type'"></dd>
            </div>
        </dl>
    </div>

    <div class="flex justify-end border-t border-white/10 px-6 py-4">
        <button @click="modal = false"
            class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition hover:bg-blue-500"
            type="button">
            Close
        </button>
    </div>
</div>
