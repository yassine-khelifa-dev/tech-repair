<form method="GET" action="{{ route('repair-tickets.index') }}"
    class="my-5  rounded-xl border border-gray-700 bg-slate-900/70 p-4">
    <div class="flex flex-wrap items-end gap-4">

        {{-- customer --}}
        <div class="w-52">
            <label class="mb-2 block text-sm font-medium text-gray-300">
                Customer
            </label>

            <input  type="text" name="customer" value="{{ request('customer') }}" placeholder="Customer name..."
                class="w-full rounded-lg border border-gray-700 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- Status --}}
        <div class="w-56">
            <label class="mb-2 block text-sm font-medium text-gray-300">
                Status
            </label>

            <select name="status" onchange="this.form.submit()"
                class="w-full rounded-lg border border-gray-700 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-blue-500 focus:ring-blue-500">
                <option value="all" @selected(request('status', 'all') === 'all')>
                    All statuses
                </option>

                @foreach (\App\Enums\RepairStatus::cases() as $item)
                    <option value="{{ $item->value }}" @selected(request('status') === $item->value)>
                        {{ str_replace('_', ' ', ucfirst(strtolower($item->name))) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Start date --}}
        <div class="w-52">
            <label class="mb-2 block text-sm font-medium text-gray-300">
                Start date
            </label>

            <input type="date" name="start" value="{{ request('start') }}" onchange="this.form.submit()"
                class="w-full rounded-lg border border-gray-700 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- End date --}}
        <div class="w-52">
            <label class="mb-2 block text-sm font-medium text-gray-300">
                End date
            </label>

            <input type="date" name="end" value="{{ request('end') }}" onchange="this.form.submit()"
                class="w-full rounded-lg border border-gray-700 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- Apply --}}
        <button type="submit"
            class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-500">
            Apply
        </button>

        {{-- Reset --}}
        <a href="{{ route('repair-tickets.index') }}"
            class="rounded-lg border border-gray-700 px-5 py-2.5 text-sm font-semibold text-gray-300 hover:bg-slate-800">
            Reset
        </a>
    </div>
</form>
