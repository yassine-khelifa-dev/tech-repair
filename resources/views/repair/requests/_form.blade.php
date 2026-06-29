{{-- Left: Review Form --}}
<form x-data="{
    loading: false,
    loadingAiReply: false,
    status: '{{ old('status', 'approved') }}'
}" @submit="loading = true" action="{{ route('repair-requests.review', $repair_request->id) }}"
    method="POST" class="rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl overflow-hidden">
    @csrf

    {{-- Form Header --}}
    <div class="border-b border-slate-800 bg-slate-950/70 p-6">
        <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">
            Admin decision
        </p>

        <h2 class="mt-1 text-2xl font-bold text-white">
            Approve or reject this request
        </h2>

        <p class="mt-2 text-sm text-gray-400">
            Generate a suggested reply, edit it if needed, then choose the final decision.
        </p>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="m-6 rounded-2xl border border-red-500/30 bg-red-500/10 p-5 text-red-200">
            <div class="flex items-start gap-4">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-500/20 text-red-300 font-bold">
                    !
                </div>

                <div>
                    <h3 class="font-bold text-red-300">
                        Please fix the following errors
                    </h3>

                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li class="flex gap-2">
                                <span class="mt-2 h-1.5 w-1.5 rounded-full bg-red-400"></span>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="space-y-6 p-6">

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

        {{-- AI Reply --}}
        <div>
            <div class="mb-3 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <label class="text-sm font-semibold text-gray-300">
                    Response to customer
                </label>

                <button type="button" id="bt-gen-ai-replay" @click="loadingAiReply = true" :disabled="loadingAiReply"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-yellow-600 px-4 py-2 text-sm font-bold text-white shadow-lg transition hover:bg-yellow-500 disabled:cursor-not-allowed disabled:bg-slate-600 disabled:opacity-60">
                    <span x-show="!loadingAiReply">
                        Generate AI Reply
                    </span>

                    <span x-show="loadingAiReply" class="inline-flex items-center gap-2">
                        <span
                            class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                        Generating...
                    </span>
                </button>
            </div>

            <textarea name="response" id="tx_response" rows="7" placeholder="Write your response to the customer..."
                class="w-full rounded-2xl border border-slate-700 bg-black/40 px-4 py-4 text-white placeholder-gray-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('response') }}</textarea>

            <x-forms.error-message name="response" />
        </div>

        {{-- Decision Cards --}}
        <div>
            <input type="hidden" name="status" x-model="status">

            <label class="mb-3 block text-sm font-semibold text-gray-300">
                Final decision
            </label>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                {{-- Approve --}}
                <div @click="status = 'approved'"
                    :class="status === 'approved'
                        ?
                        'border-emerald-500 bg-emerald-500/10' :
                        'border-slate-700 bg-slate-950 hover:border-slate-500'"
                    class="cursor-pointer rounded-2xl border-2 p-5 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-600 text-xl font-bold text-white">
                            ✓
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-white">
                                Approve Request
                            </h3>
                            <p class="text-sm text-gray-400">
                                Create repair ticket and notify customer.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Reject --}}
                <div @click="status = 'rejected'"
                    :class="status === 'rejected'
                        ?
                        'border-red-500 bg-red-500/10' :
                        'border-slate-700 bg-slate-950 hover:border-slate-500'"
                    class="cursor-pointer rounded-2xl border-2 p-5 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-red-600 text-xl font-bold text-white">
                            ×
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-white">
                                Reject Request
                            </h3>
                            <p class="text-sm text-gray-400">
                                Reject and send response to customer.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <x-forms.error-message name="status" />
        </div>

        {{-- Submit --}}
        <button type="submit" :disabled="loading"
            class="w-full rounded-2xl bg-blue-600 py-4 text-lg font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-500 disabled:cursor-not-allowed disabled:bg-slate-600 disabled:opacity-60">
            <span x-show="!loading">
                Submit Review
            </span>

            <span x-show="loading" class="inline-flex items-center justify-center gap-2">
                <span class="h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                Processing...
            </span>
        </button>
    </div>
</form>
