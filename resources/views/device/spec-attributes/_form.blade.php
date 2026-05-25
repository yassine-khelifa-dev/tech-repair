    <div class="mx-auto max-w-5xl px-4 py-8" x-data="{
        form_input_type: {{ Js::from(old('input_type', $spec_attribute?->input_type ?? 'select')) }},
        form_is_required: {{ Js::from(old('is_required', $spec_attribute?->is_required ?? false)) }},
        form_is_filterable: {{ Js::from(old('is_filterable', $spec_attribute?->is_filterable ?? false)) }},
        form_attribute_name: {{ Js::from(old('name', $spec_attribute?->name ?? '')) }},
        form_code: {{ Js::from(old('code', $spec_attribute?->code ?? '')) }},
        form_sort_order: {{ Js::from(old('sort_order', $spec_attribute?->sort_order ?? '')) }},
        form_spec_options: {{ Js::from(old('spec_options', $spec_attribute?->specOptions?->pluck('value')->values()->toArray() ?: [''])) }},

        init() {
            this.$watch('form_attribute_name', value => {
                this.form_code = value.toLowerCase().replaceAll(' ', '_')
            })
        },

        remove(index) {
            if (this.form_spec_options.length > 1) {
                this.form_spec_options.splice(index, 1)
            }
        },

        addOption() {
            this.form_spec_options.push('')
        }
    }">

        <form action="{{ $action }}" method="POST" class="space-y-8" x-init="init()">
            @csrf

            @if ($method == 'PUT')
                @method('PUT')
            @endif



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
                                <x-forms.input name="name" :value="old('name', $spec_attribute?->name ?? '')" label="Attribute Name"
                                    model="form_attribute_name" />
                                <x-forms.error-message name="name" />

                            </div>

                            <div>
                                {{-- Code --}}
                                <x-forms.input name="code" label="Technical Code " model="form_code" />
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
                                <x-forms.select name="input_type" label="Input Type" model="form_input_type">
                                    <option class="bg-gray-950 text-white" value="">
                                        Select input type...
                                    </option>

                                    @foreach (\App\Enums\SpecInputType::cases() as $type)
                                        <option value="{{ $type->value }}">
                                            {{ $type->value }}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                                <x-forms.error-message name="input_type" />
                            </div>


                            {{-- Unit --}}
                            <div>
                                <x-forms.select name="unit" label="Unit">
                                    <option class="bg-gray-950 text-white" value="{{ null }}" selected>
                                        Select unit (GB, TB, W)...
                                    </option>
                                    @foreach (\App\Enums\SpecUnit::cases() as $unit)
                                        <option value="{{ $unit->value }}"
                                            {{ old('unit', $spec_attribute?->unit) == $unit->value ? 'selected' : '' }}>
                                            {{ $unit->value }}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                                <x-forms.error-message name="unit" />

                            </div>

                            <div>
                                {{-- Sort Order --}}
                                <x-forms.input name="sort_order" label="Sort Order" :value="old('sort_order', $spec_attribute?->sort_order ?? '')" />
                                <p class="mt-1 text-xs text-gray-500">
                                    Controls the display position in forms.
                                </p>
                                <x-forms.error-message name="sort_order" />
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">

                            {{-- Requires & Filterbale --}}
                            <x-forms.checkbox name="is_required" label="Required Attribute" model="form_is_required" />
                            <x-forms.error-message name="is_required" />

                            <x-forms.checkbox name="is_filterable" label="Filterable Attribute"
                                model="form_is_filterable" />
                            <x-forms.error-message name="is_filterable" />


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
                                    <option value="{{ $item->id }}"
                                        {{ in_array($item->id, $selectedDeviceTypes) ? 'selected' : '' }}>
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
                        Field ( <span x-text="form_input_type"></span> )
                    </label>



                    @foreach ($errors->get('spec_options.*') as $messages)
                        @foreach ($messages as $message)
                            <div class="mt-1 text-sm text-red-400">
                                {{ $message }}
                            </div>
                        @endforeach
                    @endforeach


                    <template x-for="(value, row) in form_spec_options" :key="row">
                        <div class="mt-2 flex items-center gap-2">
                            <input :id="'attribute_' + row" x-model="form_spec_options[row]"
                                x-bind:placeholder="form_attribute_name" type="text"
                                :name="'spec_options[' + row + ']'"
                                class="block w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" />

                            <div x-show="['select','multiselect'].includes(form_input_type)">
                                {{-- Add --}}
                                <button type="button" @click="addOption()"
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


    </div>
