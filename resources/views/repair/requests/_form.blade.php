<form x-data="{
    loading_ai_replay: false,
    loading: false,
    status: 'approved'
}" @submit="loading = true" action="{{ route('repair-requests.review', $repair_request->id) }}"
    method="POST" class="mb-8 rounded-2xl border border-slate-700 bg-slate-900/80 shadow-xl overflow-hidden">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
            <div class="my-5">
                <button type="button" id="bt-gen-ai-replay" @click="loading_ai_replay = true"
                    :disabled="loading_ai_replay"
                    class=" rounded-xl bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-2 text-lg transition shadow-lg disabled:bg-gray-500">
                    Generate AI Reply
                </button>
            </div>


            <textarea name="response" id="tx_response" rows="5" placeholder="Write your note for this repair request..."
                class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white placeholder-gray-500 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('response') }}</textarea>
            <x-forms.error-message name="response" />

        </div>

        <div class="space-y-5">
            <input type="hidden" name="status" x-model="status">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div @click="status = 'approved'"
                    :class="status === 'approved'
                        ?
                        'border-emerald-500 bg-emerald-500/10' :
                        'border-slate-700 bg-slate-900 hover:border-slate-500'"
                    class="cursor-pointer rounded-2xl border-2 p-5 transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-600 text-white font-bold">
                            ✓
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-white">
                                Approve Request
                            </h3>
                            <p class="text-sm text-gray-400">
                                Create a repair ticket and notify the customer.
                            </p>
                        </div>
                    </div>
                </div>

                <div @click="status = 'rejected'"
                    :class="status === 'rejected'
                        ?
                        'border-red-500 bg-red-500/10' :
                        'border-slate-700 bg-slate-900 hover:border-slate-500'"
                    class="cursor-pointer rounded-2xl border-2 p-5 transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-red-600 text-white font-bold">
                            ✕
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-white">
                                Reject Request
                            </h3>
                            <p class="text-sm text-gray-400">
                                Reject the request and send your response.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <x-forms.error-message name="status" />

            <button type="submit" :disabled="loading"
                class="w-full rounded-2xl bg-blue-600 hover:bg-blue-700 disabled:bg-slate-600 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold py-4 text-lg transition shadow-lg">
                <span x-show="!loading">
                    Submit Review
                </span>

                <span x-show="loading" class="inline-flex items-center justify-center gap-2">
                    <span class="h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                    Processing...
                </span>
            </button>
        </div>
    </div>
</form>
