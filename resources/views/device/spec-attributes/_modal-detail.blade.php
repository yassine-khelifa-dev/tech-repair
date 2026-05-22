<div class="relative  max-h-[90vh] overflow-y-auto  scroll-smooth m-4 w-2/5 min-w-[40%] max-w-[40%] rounded-2xl border border-slate-200 bg-white shadow-2xl">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

        <div>
            <h2 class="text-xl font-semibold text-slate-800">
                Attribute Details
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Full information about this specification attribute.
            </p>
        </div>

        <div
            class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-600"
            x-text="model_selected?.id"
        ></div>

    </div>

    {{-- Body --}}
    <div class="space-y-6 px-6 py-6">

        {{-- Basic Info --}}
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">
                Basic Information
            </h3>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Attribute Name
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700"
                        x-text="model_selected?.name">
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Technical Code
                    </p>

                    <p class="mt-1 text-sm font-semibold text-indigo-600"
                        x-text="model_selected?.code">
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Input Type
                    </p>

                    <span
                        class="mt-1 inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700"
                        x-text="model_selected?.input_type">
                    </span>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Unit
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700"
                        x-text="model_selected?.unit">
                    </p>
                </div>

            </div>

        </div>

        {{-- Configuration --}}
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">
                Configuration
            </h3>

            <div class="flex flex-wrap gap-3">

                <span
                    x-show="model_selected?.is_required"
                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700"
                >
                    Required
                </span>

                <span
                    x-show="model_selected?.is_filterable"
                    class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700"
                >
                    Filterable
                </span>

                <span
                    class="inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-700"
                >
                    Sort:
                    <span class="ml-1" x-text="model_selected?.sort_order"></span>
                </span>

            </div>

        </div>

        {{-- Device Types --}}
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">
                Device Types
            </h3>

            <div class="flex flex-wrap gap-2">

                <template x-for="type in model_selected?.device_types">

                    <span
                        class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700"
                        x-text="type.name">
                    </span>

                </template>

            </div>

        </div>

        {{-- Options --}}
        <div
            x-show="model_selected?.spec_options?.length"
            class="rounded-xl border border-slate-200 bg-slate-50 p-4"
        >

            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">
                Options
            </h3>

            <div class="flex flex-wrap gap-2">

                <template x-for="option in model_selected?.spec_options">

                    <span
                        class="inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-700"
                    >
                        <span x-text="option.label"></span>
                    </span>

                </template>

            </div>

        </div>

        {{-- Dates --}}
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">
                Dates
            </h3>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Created At
                    </p>

                    <p class="mt-1 text-sm text-slate-700"
                        x-text="new Date(model_selected?.created_at).toLocaleString()">
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Updated At
                    </p>

                    <p class="mt-1 text-sm text-slate-700"
                        x-text="new Date(model_selected?.updated_at).toLocaleString()">
                    </p>
                </div>

            </div>

        </div>

    </div>

    {{-- Footer --}}
    <div class="flex items-center justify-end border-t border-slate-200 px-6 py-4">

        <button
            @click="modal = false"
            class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-medium text-white transition hover:bg-indigo-500"
            type="button"
        >
            Close
        </button>

    </div>

</div>
