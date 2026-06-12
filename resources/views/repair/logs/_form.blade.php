<div class="bg-gray-800 rounded-xl border border-gray-700 p-6 mt-6">

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-white">
            Add Activity
        </h2>
        <p class="text-sm text-gray-400 mt-1">
            Add a technical note and optionally update the repair status.
        </p>
    </div>

    <form action="{{ route('repair-ticket-logs', $repair_ticket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Message --}}
        <div class="mb-6">
            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">
                Activity Note
            </label>

            <textarea id="message" rows="4" name="message"
                placeholder="Describe the work performed, findings, customer communication..."
                class="w-full rounded-lg border border-gray-600 bg-gray-900 text-white px-4 py-3 focus:border-blue-500 focus:ring-blue-500">{{ old('message') }}</textarea>

            <x-forms.error-message name="message" />
        </div>

        {{-- Status --}}
        <div class="mb-6">
            <x-forms.select name="new_status" label="Repair Status">

                @foreach (\App\Enums\RepairStatus::cases() as $type)
                    <option value="{{ $type->value }}" {{ $repair_ticket->status == $type->value ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $type->value)) }}
                    </option>
                @endforeach

            </x-forms.select>

            <x-forms.error-message name="new_status" />
        </div>

        {{-- Visibility --}}
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-300 mb-3">
                Visibility
            </label>

            <div class="space-y-3">

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio" name="is_visible_to_customer" value="0" checked class="text-blue-600">

                    <div>
                        <div class="text-white font-medium">
                            Internal Only
                        </div>
                        <div class="text-gray-400 text-sm">
                            Visible only to technicians and administrators.
                        </div>
                    </div>
                </label>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio" name="is_visible_to_customer" value="1" class="text-blue-600">

                    <div>
                        <div class="text-white font-medium">
                            Visible to Customer
                        </div>
                        <div class="text-gray-400 text-sm">
                            This activity can be displayed to the customer.
                        </div>
                    </div>
                </label>
            </div>
            <x-forms.error-message name="is_visible_to_customer" />
        </div>


        {{-- Images --}}
        <x-forms.upload_images name="images_log" />


        {{-- Actions --}}
        <div class="flex justify-end gap-3">

            <a href="{{ route('repair-tickets.show', $repair_ticket) }}"
                class="px-4 py-2 rounded-lg bg-gray-700 text-white hover:bg-gray-600">
                Cancel
            </a>

            <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Add Activity
            </button>

        </div>

    </form>
</div>
