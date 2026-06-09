<div class="text-white">
    <form action="{{ route('repair-ticket-logs', $repair_ticket->id) }}" method="POST">
        @csrf
        {{-- Log Message --}}
        <div class="my-4 text-white">
            <label for="message" class="block mb-2.5 text-sm font-medium text-heading">
                Message:</label>
            <textarea id="message" rows="2" name="message"
                class="bg-neutral-secondary-medium text-black border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                placeholder="Write message  here...">{{ old('message', '') }}</textarea>
            <x-forms.error-message name="message" />
        </div>

        <div class="my-4 text-white">
            {{--  New Status --}}
            <x-forms.select name="new_status"  label="Status actuals">
                @foreach (\App\Enums\RepairStatus::cases() as $type)
                    <option value="{{ $type->value }}" {{ $repair_ticket->status == $type->value ? 'selected' : '' }}>
                        {{ $type->value }}
                    </option>
                @endforeach
            </x-forms.select>
            <x-forms.error-message name="new_status" />
        </div>

        {{-- is_visible_to_customer  --}}
        <div>
            <div class="flex items-center mb-4">
                <input id="is_visible_to_customer_opt1" type="radio" value="1" name="is_visible_to_customer"
                    class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
                <label for="is_visible_to_customer_opt1" class="select-none ms-2 text-sm font-medium text-heading">
                    Show to customer</label>
            </div>
            <div class="flex items-center">
                <input checked id="is_visible_to_customer_opt2" type="radio" value="0"
                    name="is_visible_to_customer"
                    class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
                <label for="is_visible_to_customer_opt2" class="select-none ms-2 text-sm font-medium text-heading">
                    Hide to customer</label>
            </div>
            <x-forms.error-message name="is_visible_to_customer" />

        </div>

        {{-- Actions  --}}
        <div>
            <div class="flex items-center justify-end gap-x-2">
                <a href="" type="button"
                    class="rounded-md px-3 py-2 text-sm font-semibold text-white bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    Cancel</a>
                <button type="submit"
                    class="rounded-md px-3 py-2 text-sm font-semibold text-white bg-red-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    Add
                </button>
            </div>
        </div>
    </form>
</div>
