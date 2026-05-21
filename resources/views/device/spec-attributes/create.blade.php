@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-8" x-data="{
        'input_type': 'text',
        'label': '',
        'list_size': 1,
        'list_options': [],
        remove(index){
            if (this.list_size > 1) {
                this.list_options.splice(index, 1);
                this.list_size--;
            }
        }
    }">
        <form action="{{ route('spec-attribute.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="rounded-2xl border border-white/10 bg-gray-900/70 shadow-xl">
                <div class="border-b border-white/10 px-6 py-5">
                    <h2 class="text-xl font-semibold text-white">Create Spec Attribute</h2>
                    <p class="mt-1 text-sm text-gray-400">
                        Define a dynamic specification attribute and assign it to device types.
                    </p>
                </div>

                <div class="space-y-8 px-6 py-6">

                    {{-- Main Information --}}
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-300">
                            Main Information
                        </h3>

                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-white">
                                    Attribute Name
                                </label>
                                <input id="name" x-model="label" value="{{ old('name', '') }}" placeholder="Storage"
                                    type="text" name="name" autocomplete="given-name"
                                    class="mt-2 block w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" />
                                @error('name')
                                    <div class="mt-1 text-sm text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="code" class="block text-sm font-medium text-white">
                                    Technical Code
                                </label>
                                <input id="code" value="{{ old('code') }}" placeholder="storage" type="text"
                                    name="code" autocomplete="given-name"
                                    class="mt-2 block w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" />
                                <p class="mt-1 text-xs text-gray-500">
                                    Unique internal identifier used by the system.
                                </p>
                                @error('code')
                                    <div class="mt-1 text-sm text-red-400">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Configuration --}}
                    <div class="rounded-xl border border-white/10 bg-black/20 p-5">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-300">
                            Configuration
                        </h3>

                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="input_type" class="block text-sm font-medium text-white">
                                    Input Type
                                </label>
                                <select id="input_type" name="input_type"
                                    class="mt-2 block w-full rounded-lg border border-white/10 bg-gray-950 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                    <option class="bg-gray-950 text-white" value="{{ null }}" selected>
                                        Select input type...
                                    </option>

                                    @foreach (\App\Enums\SpecInputType::cases() as $type)
                                        <option value="{{ $type->value }}"
                                            @click='input_type =  @json($type->value) '
                                            {{ old('input_type') === $type->value ? 'selected' : '' }}>
                                            {{ $type->value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('input_type')
                                    <div class="mt-1 text-sm text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-white">
                                    Sort Order
                                </label>
                                <input id="sort_order" value="{{ old('sort_order') }}" placeholder="1" type="text"
                                    name="sort_order" autocomplete="given-name"
                                    class="mt-2 block w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" />
                                <p class="mt-1 text-xs text-gray-500">
                                    Controls the display position in forms.
                                </p>
                                @error('sort_order')
                                    <div class="mt-1 text-sm text-red-400">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <label for="is_required"
                                class="flex cursor-pointer items-start gap-3 rounded-lg border border-white/10 bg-white/5 p-4 text-white hover:bg-white/10">
                                <input id="is_required" name="is_required" type="checkbox" value="1"
                                    class="mt-1 h-4 w-4 rounded border-white/20 bg-gray-900 text-indigo-500 focus:ring-indigo-500">
                                <span>
                                    <span class="block text-sm font-medium">Required Attribute</span>
                                    <span class="block text-xs text-gray-400">
                                        User must provide this value when creating a device.
                                    </span>
                                </span>
                            </label>

                            <label for="is_filterable"
                                class="flex cursor-pointer items-start gap-3 rounded-lg border border-white/10 bg-white/5 p-4 text-white hover:bg-white/10">
                                <input id="is_filterable" name="is_filterable" type="checkbox" value="1"
                                    class="mt-1 h-4 w-4 rounded border-white/20 bg-gray-900 text-indigo-500 focus:ring-indigo-500">
                                <span>
                                    <span class="block text-sm font-medium">Filterable Attribute</span>
                                    <span class="block text-xs text-gray-400">
                                        Can be used later in search and filters.
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Device Types --}}
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-300">
                            Device Types
                        </h3>

                        <div class="mt-4">
                            <label for="countries_multiple" class="block text-sm font-medium text-white">
                                Select Types
                            </label>

                            <select multiple id="countries_multiple" name="devicetypes[]"
                                class="mt-2 block min-h-40 w-full rounded-lg border border-white/10 bg-gray-950 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                @foreach ($devicetypes as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                            <p class="mt-2 text-xs text-gray-500">
                                Hold Cmd/Ctrl to select multiple device types.
                            </p>

                            @error('devicetypes')
                                <div class="mt-1 text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="m-4">
                    <h1 class="mb-5 block text-sm font-medium text-white">
                        Options
                    </h1>

                    <label for="name" class="block text-sm font-medium text-white">
                        Field ( <span x-text="input_type"></span> )
                    </label>

                    <template x-for="row in list_size ">
                        <div class="mt-2 flex items-center gap-2">
                            <input :id="'attribute_' + row"
                                x-model="list_options[row]"
                                x-bind:placeholder="label" type="text"
                                :name="'list_options[' + row + ']'"
                                value="{{ old('name', '') }}"
                                class="block w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" />


                            <div x-show=" input_type == 'select' || input_type == 'multiselect' ">
                                {{-- Add --}}
                                <button type="button" @click="list_size++"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-500 text-white transition hover:bg-indigo-400">
                                    +
                                </button>

                                {{-- Remove --}}
                                <button type="button" @click="remove()"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-500 text-white transition hover:bg-red-400">
                                    -
                                </button>
                            </div>
                        </div>

                        @error('name')
                            <div class="mt-1 text-sm text-red-400">
                                {{ $message }}
                            </div>
                        @enderror
                    </template>

                </div>


            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('spec-attribute.index') }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-300 hover:bg-white/10 hover:text-white">
                    Cancel
                </a>

                <button type="submit"
                    class="rounded-lg bg-indigo-500 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-950">
                    Save Attribute
                </button>
            </div>
        </form>
    </div>
@endsection
