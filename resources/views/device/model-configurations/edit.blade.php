@extends('layouts.admin')

@section('content')
    <form action="{{ route('device-model-configuration.update', $devicemodel->id) }}" method="POST">
        @csrf
        @method('PUT')


        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 mx-2 my-5 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mx-auto max-w-5xl px-4 py-8" x-data="{
            selectedOptions: [],

            toggleAttribute(optionIds) {
                const allSelected = optionIds.every(id => this.selectedOptions.includes(id))

                if (allSelected) {
                    this.selectedOptions = this.selectedOptions.filter(id => !optionIds.includes(id))
                } else {
                    this.selectedOptions = [...new Set([...this.selectedOptions, ...optionIds])]
                }
            },

            isAttributeSelected(optionIds) {
                return optionIds.every(id => this.selectedOptions.includes(id))
            },
            reset() { this.selectedOptions = [] }
        }">
            <div class="rounded-2xl border border-white/10 bg-gray-900/70 shadow-xl">

                <div class="border-b border-white/10 px-6 py-5">
                    <h1 class="text-xl font-semibold text-white">
                        Model Configuration
                    </h1>

                    <p class="mt-2 text-sm text-gray-400">
                        {{ $devicemodel->type->name }} /
                        {{ $devicemodel->brand->name }} /
                        {{ $devicemodel->name }}
                    </p>
                </div>

                {{-- Global Error --}}
                @error('allowed_options')
                    <div class="mt-4 rounded-lg border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        {{ $message }}
                    </div>
                @enderror

                <div class="space-y-8 px-6 py-6">
                    @foreach ($devicemodel->type->specAttributes as $row)
                        @php
                            $optionIds = $row->specOptions->pluck('id')->values()->toArray();
                        @endphp

                        <div class="rounded-xl border border-white/10 bg-black/20 p-5">
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-white">
                                        {{ $row->name }}
                                    </h3>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Select allowed options for this model.
                                    </p>
                                </div>

                                <label
                                    class="inline-flex cursor-pointer items-center gap-2 rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-medium text-indigo-300">
                                    <input type="checkbox" @click="toggleAttribute(@js($optionIds))"
                                        :checked="isAttributeSelected(@js($optionIds))"
                                        class="h-4 w-4 rounded border-white/20 bg-gray-900 text-indigo-500 focus:ring-indigo-500">

                                    {{ $row->input_type }}

                                    <button type="button" class="text-white" @click="reset">Reset</button>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($row->specOptions as $option)
                                    <label
                                        class="flex cursor-pointer items-center gap-3 rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-white transition hover:bg-white/10">
                                        <input type="checkbox" name="allowed_options[]" value="{{ $option->id }}"
                                            x-model="selectedOptions"
                                            class="h-4 w-4 rounded border-white/20 bg-gray-900 text-indigo-500 focus:ring-indigo-500">

                                        <span class="text-sm font-medium">
                                            {{ $option->label }}
                                            {{ $row->unit == 'None' ? '' : $row->unit }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-end gap-4 border-t border-white/10 px-6 py-4">
                    <a href="{{ route('devicemodel.index') }}"
                        class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-300 hover:bg-white/10 hover:text-white">
                        Cancel
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-indigo-500 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 hover:bg-indigo-400">
                        Save Configuration
                    </button>
                </div>

            </div>
        </div>
    </form>
@endsection
