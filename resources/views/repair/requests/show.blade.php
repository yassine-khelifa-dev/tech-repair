@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 text-white">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-bold text-white">
                        Repair Request Review
                    </h1>

                    <span
                        class="rounded-full border border-yellow-500/30 bg-yellow-500/10 px-3 py-1 text-sm font-semibold text-yellow-300">
                        {{ ucfirst($repair_request->status) }}
                    </span>
                </div>

                <p class="mt-1 text-gray-400">
                    Request #{{ $repair_request->id }} · Review the customer request and send a professional response.
                </p>
            </div>

            <a href="{{ route('repair-requests.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-white transition hover:bg-slate-700">
                Back
            </a>
        </div>

        <div x-data="{ detailsOpen: false }">

            {{-- Main Layout --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1.2fr_0.8fr]">

                {{-- form --}}
                @if ($repair_request->status !== \App\Enums\RepairRequestStatus::rejected->value)
                    @include('repair.requests._form')
                @else
                    {{-- Customer Issue --}}
                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-5">
                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-white">
                                Customer Issue
                            </h3>

                            <button type="button" @click="detailsOpen = true"
                                class="rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm font-semibold text-gray-300 transition hover:bg-slate-700 hover:text-white">
                                View full details
                            </button>
                        </div>

                        <p id="issue_description" class="leading-7 text-gray-300">
                            {{ $data['issue_description'] }}
                        </p>
                    </div>
                @endif

                {{-- Right: Summary --}}
                <div class="space-y-6">

                    {{-- Customer --}}
                    <div class="rounded-3xl border border-slate-800 bg-slate-900/80 p-6 shadow-xl">
                        <div class="mb-5 flex items-center justify-between">
                            <h2 class="text-xl font-bold text-white">
                                Customer
                            </h2>

                            <span class="rounded-full bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-300">
                                Contact
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="mt-1 font-semibold text-white">{{ $data['fullname'] }}</p>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="mt-1 font-semibold text-white">{{ $data['email'] }}</p>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="mt-1 font-semibold text-white">{{ $data['phone'] }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Device --}}
                    <div class="rounded-3xl border border-slate-800 bg-slate-900/80 p-6 shadow-xl">
                        <div class="mb-5 flex items-center justify-between">
                            <h2 class="text-xl font-bold text-white">
                                Device
                            </h2>

                            <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-300">
                                Repair
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <p class="text-sm text-gray-500">Type</p>
                                <p class="mt-1 font-semibold text-white">{{ $device_model->type->name }}</p>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <p class="text-sm text-gray-500">Brand</p>
                                <p class="mt-1 font-semibold text-white">{{ $device_model->brand->name }}</p>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <p class="text-sm text-gray-500">Model</p>
                                <p class="mt-1 font-semibold text-white">{{ $device_model->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Details Modal --}}
            <div x-show="detailsOpen" x-cloak x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4 py-6">
                <div @click="detailsOpen = false" class="absolute inset-0"></div>

                <div @click.stop x-transition.scale.origin.center
                    class="relative z-10 max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-3xl border border-slate-700 bg-slate-950 shadow-2xl">
                    <div class="flex items-center justify-between border-b border-slate-800 bg-slate-900 p-6">
                        <div>
                            <h2 class="text-2xl font-bold text-white">
                                Full Request Details
                            </h2>
                            <p class="text-sm text-gray-400">
                                Complete customer and device information.
                            </p>
                        </div>

                        <button type="button" @click="detailsOpen = false"
                            class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-700 bg-slate-800 text-xl text-gray-300 hover:bg-slate-700 hover:text-white">
                            ×
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-6 p-6 lg:grid-cols-2">
                        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                            <h3 class="mb-4 text-lg font-bold text-white">
                                Technical Details
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">IMEI</p>
                                    <p class="font-semibold text-white">{{ $data['imei'] ?? 'Not provided' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Serial Number</p>
                                    <p class="font-semibold text-white">{{ $data['sn'] ?? 'Not provided' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Current Status</p>
                                    <span
                                        class="mt-1 inline-flex rounded-full border border-yellow-500/30 bg-yellow-500/10 px-3 py-1 text-sm font-semibold text-yellow-300">
                                        {{ ucfirst($repair_request->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                            <h3 class="mb-4 text-lg font-bold text-white">
                                Device Photos
                            </h3>

                            <x-forms.image-gallery :images="$images" title="Device Photos" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const aiButton = document.getElementById('bt-gen-ai-replay');
        const issueDescriptionElement = document.getElementById('issue_description');
        const responseTextarea = document.getElementById('tx_response');

        if (aiButton && issueDescriptionElement && responseTextarea) {
            aiButton.addEventListener('click', async function() {
                const issueDescription = issueDescriptionElement.textContent.trim();

                try {
                    const response = await fetch("{{ route('repair-request.ai-replay') }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            issue_description: issueDescription
                        })
                    });

                    const data = await response.json();

                    responseTextarea.value = data.response ?? '';

                } catch (error) {
                    console.error(error);
                } finally {
                    const event = new CustomEvent('ai-reply-finished');
                    window.dispatchEvent(event);
                }
            });

            window.addEventListener('ai-reply-finished', function() {
                const alpineRoot = document.querySelector('[x-data]');
                if (alpineRoot && alpineRoot.__x) {
                    alpineRoot.__x.$data.loadingAiReply = false;
                }
            });
        }
    </script>
@endsection
