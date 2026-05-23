<form action="{{ route('spec-attribute.store') }}" method="POST" class="space-y-8" x-init="init()">
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
                        {{-- Name  --}}
                        <x-forms.input name="name" label="Attribute Name" model="attribute_name" />
                        <x-forms.error-message name="name" />

                    </div>

                    <div>
                        {{-- Code --}}
                        <x-forms.input name="code" label="Technical Code " model="code" />
                        <x-forms.error-message name="code" />

                    </div>
                </div>
            </div>

            {{-- Configuration --}}
            <div class="rounded-xl border border-white/10 bg-black/20 p-5">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-300">
                    Configuration
                </h3>

                <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
                    {{-- Input Type --}}
                    <div>
                        <x-forms.select name="input_type" label="Input Type" model="input_type">
                            <option class="bg-gray-950 text-white" value="{{ null }}" selected>
                                Select input type...
                            </option>

                            @foreach (\App\Enums\SpecInputType::cases() as $type)
                                <option value="{{ $type->value }}" 
                                    {{ old('input_type') === $type->value ? 'selected' : '' }}>
                                    {{ $type->value }}
                                </option>
                            @endforeach
                        </x-forms.select>
                        <x-forms.error-message name="input_type" />
                    </div>


                    {{-- Unit --}}
                    <div>
                        <x-forms.select name="unit" label="Unit" model="unit">
                            <option class="bg-gray-950 text-white" value="{{ null }}" selected>
                                Select unit (GB, TB, W)...
                            </option>
                            @foreach (\App\Enums\SpecUnit::cases() as $unit)
                                <option value="{{ $unit->value }}"
                                    {{ old('unit') === $unit->value ? 'selected' : '' }}>
                                    {{ $unit->value }}
                                </option>
                            @endforeach
                        </x-forms.select>
                        <x-forms.error-message name="unit" />

                    </div>

                    <div>
                        {{-- Sort Order --}}
                        <x-forms.input name="sort_order" label="Sort Order" />
                        <p class="mt-1 text-xs text-gray-500">
                            Controls the display position in forms.
                        </p>
                        <x-forms.error-message name="sort_order" />
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">

                    {{-- Requires & Filterbale --}}
                    <x-forms.checkbox name="is_required" label="Required Attribute" />
                    <x-forms.error-message name="is_required" />

                    <x-forms.checkbox name="is_filterable" label="Filterable Attribute" />
                    <x-forms.error-message name="is_required" />


                </div>
            </div>

            {{-- Device Types --}}
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-300">
                    Device Types
                </h3>

                <div class="mt-4">
                    <x-forms.select name="devicetypes[]" label="Select Types" multiple="1">
                        @foreach ($devicetypes as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </x-forms.select>
                    <p class="mt-2 text-xs text-gray-500">
                        Hold Cmd/Ctrl to select multiple device types.
                    </p>
                    <x-forms.error-message name="devicetypes" />

                </div>
            </div>
        </div>




        {{-- Options --}}

        <div class="m-4">
            <h1 class="mb-5 block text-sm font-medium text-white">
                Options
            </h1>

            <label for="name" class="block text-sm font-medium text-white">
                Field ( <span x-text="input_type"></span> )
            </label>

            <template x-for="row in list_size ">
                <div class="mt-2 flex items-center gap-2">
                    <input :id="'attribute_' + row" x-model="spec_options[row]" x-bind:placeholder="attribute_name"
                        type="text" :name="'spec_options[' + row + ']'" value="{{ old('name', '') }}"
                        class="block w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" />


                    <div x-show="['select','multiselect'].includes(input_type)">
                        {{-- Add --}}
                        <button type="button" @click="list_size++"
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-500 text-white transition hover:bg-indigo-400">
                            +
                        </button>

                        {{-- Remove --}}
                        <button type="button" @click="remove(row)"
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
