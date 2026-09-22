@once
    <style>
        .visibility-radio:checked + .visibility-card {
            box-shadow: 0 0 0 2px rgb(96 165 250 / 0.28);
        }

        .visibility-radio:checked + .visibility-card-blue {
            border-color: rgb(96 165 250);
            background-color: rgb(59 130 246 / 0.10);
        }

        .visibility-radio:checked + .visibility-card-emerald {
            border-color: rgb(52 211 153);
            background-color: rgb(16 185 129 / 0.10);
            box-shadow: 0 0 0 2px rgb(52 211 153 / 0.28);
        }

        .visibility-radio:checked + .visibility-card-blue .visibility-icon,
        .visibility-radio:checked + .visibility-card-blue .visibility-check {
            background-color: rgb(59 130 246);
            border-color: rgb(96 165 250);
            color: white;
        }

        .visibility-radio:checked + .visibility-card-emerald .visibility-icon,
        .visibility-radio:checked + .visibility-card-emerald .visibility-check {
            background-color: rgb(16 185 129);
            border-color: rgb(52 211 153);
            color: white;
        }

        .visibility-radio:checked + .visibility-card .visibility-check-dot {
            display: block;
        }
    </style>
@endonce

<div class="bg-gray-800 rounded-xl border border-gray-700 p-6 mt-6">

    <div class ="mb-6">
        <h2 class="text-xl font-semibold text-white">
            Add Activity
        </h2>
        <p class="text-sm text-gray-400 mt-1">
            Add a technical note and optionally update the repair status.
        </p>
    </div>

    <form action="{{ route('repair-ticket-logs', $repair_ticket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Status --}}
        <div class="mb-6 rounded-xl border border-gray-700 bg-gray-900/70 p-4">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-500/15 text-blue-300">
                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <div>
                    <label for="new_status" class="block text-sm font-semibold text-white">
                        Repair Status
                    </label>
                    <p class="text-xs text-gray-400">Choose the next step before saving the activity.</p>
                </div>
            </div>

            <div class="relative">
                <select id="new_status" name="new_status"
                    class="block w-full appearance-none rounded-xl border border-gray-600 bg-gray-950 px-4 py-3 pr-11 text-sm font-semibold text-white shadow-inner transition focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30">
                    @foreach (\App\Enums\RepairStatus::cases() as $type)
                        <option value="{{ $type->value }}" {{ $repair_ticket->status == $type->value ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type->value)) }}
                        </option>
                    @endforeach
                </select>

                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m6 9 6 6 6-6" />
                    </svg>
                </div>
            </div>

            <x-forms.error-message name="new_status" />
        </div>

        {{-- Message --}}
        <div class="mb-6">
            <div class="mb-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <label for="message" class="block text-sm font-semibold text-white">
                        Activity Note
                    </label>
                    <p class="text-xs text-gray-400">Write the update that explains the repair activity.</p>
                </div>

                <button type="button" id="bt-gen-ai-replay"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-amber-300/30 bg-amber-400/15 px-4 py-2.5 text-sm font-bold text-amber-100 shadow-lg shadow-amber-950/20 transition hover:border-amber-300/60 hover:bg-amber-400/25 hover:text-white disabled:cursor-not-allowed disabled:border-slate-600 disabled:bg-slate-700 disabled:text-slate-300 disabled:opacity-70">
                    <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 3 4 14h7l-1 7 9-11h-7l1-7Z" />
                    </svg>
                    <span data-ai-button-label>Generate AI Reply</span>
                </button>
            </div>

            <textarea id="message" rows="4" name="message"
                placeholder="Describe the work performed, findings, customer communication..."
                class="w-full rounded-xl border border-gray-600 bg-gray-950 px-4 py-3 text-white shadow-inner transition placeholder:text-gray-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30">{{ old('message') }}</textarea>

            <x-forms.error-message name="message" />
        </div>

        {{-- Visibility --}}
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-300 mb-3">
                Visibility
            </label>

            <div class="grid gap-3 sm:grid-cols-2">

                <label class="group cursor-pointer">
                    <input type="radio" name="is_visible_to_customer" value="0" checked
                        class="visibility-radio sr-only">

                    <div
                        class="visibility-card visibility-card-blue flex min-h-24 items-center gap-4 rounded-xl border border-gray-700 bg-gray-900/70 p-4 transition hover:border-blue-400/60 hover:bg-gray-800">
                        <div
                            class="visibility-icon flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gray-800 text-gray-300 transition group-hover:bg-gray-700">
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 10.5v3m-4.5 6h9A1.5 1.5 0 0 0 18 18v-6a1.5 1.5 0 0 0-1.5-1.5h-9A1.5 1.5 0 0 0 6 12v6A1.5 1.5 0 0 0 7.5 19.5Zm1.5-9V8a3 3 0 1 1 6 0v2.5" />
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-3">
                                <span class="font-medium text-white">Internal Only</span>
                                <span
                                    class="visibility-check flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-gray-500 transition">
                                    <span class="visibility-check-dot hidden h-2 w-2 rounded-full bg-white"></span>
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-gray-400">Only technicians and administrators can see it.</p>
                        </div>
                    </div>
                </label>

                <label class="group cursor-pointer">
                    <input type="radio" name="is_visible_to_customer" value="1" class="visibility-radio sr-only">

                    <div
                        class="visibility-card visibility-card-emerald flex min-h-24 items-center gap-4 rounded-xl border border-gray-700 bg-gray-900/70 p-4 transition hover:border-emerald-400/60 hover:bg-gray-800">
                        <div
                            class="visibility-icon flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gray-800 text-gray-300 transition group-hover:bg-gray-700">
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-3">
                                <span class="font-medium text-white">Visible to Customer</span>
                                <span
                                    class="visibility-check flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-gray-500 transition">
                                    <span class="visibility-check-dot hidden h-2 w-2 rounded-full bg-white"></span>
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-gray-400">Customer can see this update in tracking.</p>
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

            <a href="{{ route('repair-tickets.index') }}"
                class="px-4 py-2 rounded-lg bg-gray-700 text-white hover:bg-gray-600">
                Cancel
            </a>

            <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Add Activity
            </button>

        </div>

    </form>
</div>



@section('script')
    <script>
        const aiButton = document.getElementById('bt-gen-ai-replay');
        const aiButtonLabel = aiButton?.querySelector('[data-ai-button-label]');
        const responseMessage = document.getElementById('message');
        const statusSelect = document.getElementById('new_status');
        const ticketId = @js($repair_ticket->id);

        if (aiButton && aiButtonLabel && responseMessage && statusSelect) {
            aiButton.addEventListener('click', async function() {
                aiButton.disabled = true;
                aiButtonLabel.textContent = 'Generating...';

                try {
                    const response = await fetch("{{ route('repair-ticket-logs.ai-replay') }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            ticket_id: ticketId,
                            new_log_msg: responseMessage.value.trim(),
                            new_status: statusSelect.value
                        })
                    });

                    const res = await response.json();

                    if (res.success === true) {
                        responseMessage.value = res.response;
                    } else {
                        alert('AI reply is not available right now.');
                    }
                } catch (error) {
                    console.error(error);
                    alert('AI service error. Please try again later.');
                } finally {
                    aiButton.disabled = false;
                    aiButtonLabel.textContent = 'Generate AI Reply';
                }
            });
        }
    </script>
@endsection
