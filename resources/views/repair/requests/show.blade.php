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

        <form action="{{ route('repair-requests.review', $repair_request->id) }}" method="POST"
            class="mb-8 rounded-2xl border border-slate-700 bg-slate-900/80 shadow-xl overflow-hidden">
            @csrf

            <div class="p-6 border-b border-slate-700">
                <h2 class="text-xl font-semibold text-white">
                    Admin Review
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    Add your note and choose whether to approve or reject this request.
                </p>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Admin Response
                    </label>

                    <textarea name="response" rows="5" placeholder="Write your note for this repair request..."
                        class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white placeholder-gray-500 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    <x-forms.error-message name="response" />

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button type="submit" name="status" value="approved"
                        class="w-full rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 text-lg transition shadow-lg">
                        Approve Request
                    </button>

                    <button type="submit" name="status" value="rejected"
                        class="w-full rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold py-4 text-lg transition shadow-lg">
                        Reject Request
                    </button>
                    <x-forms.error-message name="status" />

                </div>
            </div>
        </form>

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
                    {{ $data['issue_description'] }}
                </div>
            </div>

        </div>
    </div>
@endsection
