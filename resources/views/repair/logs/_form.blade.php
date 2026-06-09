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
        <div class="text-white mb-5">
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file"
                    class="flex flex-col items-center justify-center w-full h-64 bg-neutral-secondary-medium border border-dashed border-default-strong rounded-base cursor-pointer hover:bg-neutral-tertiary-medium">
                    <div class="flex flex-col items-center justify-center text-body pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="dropzone-file" name="images_log[]" type="file" class="hidden" accept="image/*"
                        multiple />
                </label>
                <x-forms.error-message name="images_log" />
            </div>
        </div>

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
