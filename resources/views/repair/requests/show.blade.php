@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 text-white">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white">
                    Repair Request Details
                </h1>
                <p class="text-gray-400 mt-1">
                    Request #{{ $repair_request->id }}
                </p>
            </div>

            <a href="{{ route('repair-requests.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white transition">
                Back
            </a>
        </div>


        @include('repair.requests._form')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="rounded-2xl border border-slate-700 bg-slate-900/80 shadow-xl p-6">
                <h2 class="text-xl font-semibold mb-5 text-white">
                    Customer Information
                </h2>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">Full Name</p>
                        <p class="text-lg font-medium">{{ $data['fullname'] }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Email</p>
                        <p class="text-lg font-medium">{{ $data['email'] }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Phone</p>
                        <p class="text-lg font-medium">{{ $data['phone'] }}</p>
                    </div>
                </div>

            </div>

            <div class="rounded-2xl border border-slate-700 bg-slate-900/80 shadow-xl p-6">
                <h2 class="text-xl font-semibold mb-5 text-white">
                    Device Information
                </h2>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">Type</p>
                        <p class="text-lg font-medium">{{ $device_model->type->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Brand</p>
                        <p class="text-lg font-medium">{{ $device_model->brand->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Model</p>
                        <p class="text-lg font-medium">{{ $device_model->name }}</p>
                    </div>
                </div>

                <x-forms.image-gallery :images="$images" title="Device Photos" />

            </div>

            <div class="rounded-2xl border border-slate-700 bg-slate-900/80 shadow-xl p-6">
                <h2 class="text-xl font-semibold mb-5 text-white">
                    Technical Details
                </h2>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">IMEI</p>
                        <p class="text-lg font-medium">{{ $data['imei'] }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Serial Number</p>
                        <p class="text-lg font-medium">{{ $data['sn'] }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Current Status</p>
                        <span
                            class="inline-flex mt-1 px-3 py-1 rounded-full text-sm font-semibold bg-yellow-500/20 text-yellow-300 border border-yellow-500/30">
                            {{ ucfirst($repair_request->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-700 bg-slate-900/80 shadow-xl p-6">
                <h2 class="text-xl font-semibold mb-5 text-white">
                    Issue Description
                </h2>

                <div
                    class="rounded-xl bg-slate-950 border border-slate-700 p-4 text-gray-200 leading-relaxed min-h-[150px]">
                    <span id="issue_description">{{ $data['issue_description'] }}</span>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('script')
    <script>
        document.getElementById('bt-gen-ai-replay').addEventListener('click', async function() {
            const issue_description = document.getElementById('issue_description').innerHTML;

            console.log(issue_description)

            const response = await fetch("{{ route('repair-request.ai-replay') }}", {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    issue_description: issue_description
                })
            });
            const data = await response.json();
            document.getElementById('tx_response').value = data.response

        })
    </script>
@endsection
