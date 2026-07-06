@props(['action', 'status'])

<form method="GET" action="{{ $action }}"
    class="my-5 overflow-hidden rounded-xl border border-white/10 bg-gray-800/70 shadow-xl shadow-black/10">
    <div class="border-b border-white/10 px-5 py-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/10 text-blue-300 ring-1 ring-blue-400/20">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Filters</h2>
                    <p class="mt-1 text-sm text-gray-400">Refine results by customer, status, and date range.</p>
                </div>
            </div>

            @if (request()->hasAny(['customer', 'status', 'start', 'end']))
                <span class="inline-flex w-fit rounded-full bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-200 ring-1 ring-blue-400/20">
                    Active filters
                </span>
            @endif
        </div>
    </div>

    <div class="grid gap-4 px-5 py-5 sm:grid-cols-2 xl:grid-cols-[1.3fr_1fr_1fr_1fr_auto_auto] xl:items-end">
        <div>
            <label for="filter-customer" class="mb-2 block text-sm font-semibold text-gray-200">
                Customer
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 1115 0" />
                    </svg>
                </div>
                <input id="filter-customer"
                    type="text"
                    name="customer"
                    value="{{ request('customer') }}"
                    placeholder="Customer name..."
                    class="block w-full rounded-lg border border-white/10 bg-gray-950/60 py-3 pl-11 pr-4 text-sm text-white shadow-sm outline-none transition placeholder:text-gray-500 focus:border-blue-300 focus:ring-2 focus:ring-blue-400/30">
            </div>
        </div>

        <div>
            <label for="filter-status" class="mb-2 block text-sm font-semibold text-gray-200">
                Status
            </label>
            <select id="filter-status"
                name="status"
                onchange="this.form.submit()"
                class="block w-full rounded-lg border border-white/10 bg-gray-950/60 px-4 py-3 text-sm text-white shadow-sm outline-none transition focus:border-blue-300 focus:ring-2 focus:ring-blue-400/30">
                <option class="bg-gray-950 text-white" value="all" @selected(request('status', 'all') === 'all')>
                    All statuses
                </option>

                @foreach ($status as $item)
                    <option class="bg-gray-950 text-white" value="{{ $item->value }}" @selected(request('status') === $item->value)>
                        {{ str_replace('_', ' ', ucfirst(strtolower($item->name))) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="filter-start" class="mb-2 block text-sm font-semibold text-gray-200">
                Start date
            </label>
            <input id="filter-start"
                type="date"
                name="start"
                value="{{ request('start') }}"
                onchange="this.form.submit()"
                class="block w-full rounded-lg border border-white/10 bg-gray-950/60 px-4 py-3 text-sm text-white shadow-sm outline-none transition focus:border-blue-300 focus:ring-2 focus:ring-blue-400/30">
        </div>

        <div>
            <label for="filter-end" class="mb-2 block text-sm font-semibold text-gray-200">
                End date
            </label>
            <input id="filter-end"
                type="date"
                name="end"
                value="{{ request('end') }}"
                onchange="this.form.submit()"
                class="block w-full rounded-lg border border-white/10 bg-gray-950/60 px-4 py-3 text-sm text-white shadow-sm outline-none transition focus:border-blue-300 focus:ring-2 focus:ring-blue-400/30">
        </div>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            Apply
        </button>

        <a href="{{ $action }}"
            class="inline-flex items-center justify-center rounded-lg border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-gray-200 transition hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
            Reset
        </a>
    </div>
</form>
