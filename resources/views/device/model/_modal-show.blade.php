<div class="relative m-4 p-4 w-2/5 min-w-[40%] max-w-[40%] rounded-lg bg-white shadow-sm">
    <div class="flex shrink-0 items-center pb-4 text-xl font-medium text-slate-800">
        Show Modal with ID:
        <span x-text="model_selected?.id"></span>
    </div>

    <div class="relative border-t border-slate-200 py-4 leading-normal text-slate-600 font-light">
        <ul>
            <li>Brand: <span x-text="model_selected?.brand?.name"></span></li>
            <li>Type: <span x-text="model_selected?.type?.name"></span></li>
            <li>Model name: <span x-text="model_selected?.name"></span></li>
            <hr>
            <li>Created at: <span class="text-blue-500" x-text="new Date(model_selected?.created_at).toLocaleDateString()"></span></li>
        </ul>
    </div>

    <div class="flex shrink-0 flex-wrap items-center pt-4 justify-end">
        <button
            @click="modal = false"
            class="rounded-md bg-green-600 py-2 px-4 text-sm text-white"
            type="button"
        >
            Cancel
        </button>
    </div>
</div>
