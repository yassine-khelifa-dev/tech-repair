@extends('layouts.admin')

@section('content')
    <div x-data="{
        device_model_selected: {},
        brand_selected: null,
        options_allows: null,
        get filtre_brand() {
            if (this.brand_selected)
                return this.device_model_selected.filter((d) => d.brand.id === this.brand_selected?.id)
            return this.device_model_selected;
        },
        get options() {
            if (!Array.isArray(this.options_allows)) {
                return {}
            }
            const res = {}
            this.options_allows.forEach(item => {
                const key = item.spec_attribute.name
                if (!res[key]) {
                    res[key] = []
                }

                res[key].push({
                    id: item.id,
                    label: item.spec_attribute.unit === 'None' ?
                        item.label :
                        `${item.label} ${item.spec_attribute.unit}`
                })
            })
            return res
        }

    }">
        <form action="{{ route('repair-tickets.store') }}" method="POST">
            @csrf
            <div class="space-y-12">


                <div class="border-b border-white/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-white">Create Ticket</h2>
                    <p class="mt-1 text-sm/6 text-gray-400">Use a permanent address where you can receive mail.</p>
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-3">
                        <div>
                            {{-- full name  --}}
                            <x-forms.input name="fullname" :value="old('fullname', 'yassine')" label="Full Name" />
                            <x-forms.error-message name="fullname" />
                        </div>
                        <div>
                            {{-- phone  --}}
                            <x-forms.input name="phone" :value="old('phone', '9484747')" label="Your number phone" />
                            <x-forms.error-message name="phone" />
                        </div>
                        <div>
                            {{-- email  --}}
                            <x-forms.input name="email" :value="old('email', 'hello@hy.lo')" label="Email" />
                            <x-forms.error-message name="email" />
                        </div>
                    </div>
                    <div>
                        {{--  Brand & Type --}}
                        <div class="mt-5 text-white">

                            <label for="device_type_id" class="mb-2.5 block text-sm font-medium text-white">
                                Select a Device Type
                            </label>
                            <select id="device_type_id" name="device_type_id"
                                class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">

                                <option class="bg-black text-white" value="{{ null }}" selected
                                    @click="device_model_selected = [];">
                                    Choose a type
                                </option>
                                @foreach ($devicetypes as $devicetype)
                                    <option class="bg-black text-white" value="{{ $devicetype->id }}"
                                        {{ old('device_type_id') == $devicetype->id ? 'selected' : '' }}
                                        @click="device_model_selected = {{ Js::from($devicetype->deviceModels) }}; device_model_selected_filter =  {{ Js::from($devicetype->deviceModels) }} ">
                                        {{ $devicetype->name }}

                                    </option>
                                @endforeach


                            </select>
                            @error('device_type_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-5 text-white">
                            <label for="brand_id" class="mb-2.5 block text-sm font-medium text-white">
                                Select a Brand
                            </label>

                            <select id="brand_id" name="brand_id"
                                class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">

                                <option class="bg-black text-white" value="{{ null }}" selected
                                    @click="brand_selected = null;">
                                    Choose a brand
                                </option>

                                @foreach ($brands as $brand)
                                    <option class="bg-black text-white" value="{{ $brand->id }}"
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}
                                        @click="brand_selected = {{ Js::from($brand) }};">

                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{--  Model  --}}
                    <div>
                        <div class="mt-5 text-white">
                            <label for="device_model_id" class="mb-2.5 block text-sm font-medium text-white">
                                Select a Device Model
                            </label>

                            <select id="device_model_id" name="device_model_id"
                                class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">

                                <option class="bg-black text-white" value="{{ null }}" selected>
                                    Choose a Model
                                </option>

                                <template x-for="item in filtre_brand" :key="item.id">
                                    <option class="bg-black text-white" :value="item.id" x-text="item.name"
                                        @click="options_allows = item.allowed_options; console.log( options ); ">
                                    </option>
                                </template>
                            </select>
                            @error('device_model_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    {{-- Options --}}
                    <template x-if="options_allows && Object.keys(options_allows).length">
                        <div class="mt-6 rounded-xl border border-white/10 bg-gray-900 p-5">
                            <h2 class="mb-4 text-lg font-semibold text-white">
                                Device Options
                            </h2>

                            <div class="space-y-5">
                                <template x-for="(values, key) in options" :key="key">
                                    <div class="rounded-lg border border-white/10 bg-black/20 p-4">
                                        <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-indigo-400"
                                            x-text="key">
                                        </h3>

                                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-3">
                                            <template x-for="opt in values" :key="opt.id">
                                                <label
                                                    class="flex cursor-pointer items-center gap-3 rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-white transition hover:bg-white/10">
                                                    <input type="radio" :name="'attributes[' + key + ']'"
                                                        :value="opt.id"
                                                        class="h-4 w-4 border-gray-500 bg-gray-800 text-indigo-500 focus:ring-indigo-500">

                                                    <span class="text-sm font-medium" x-text="opt.label">
                                                    </span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>




                    {{--  Detail SN, IEMI - Status --}}
                    <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-3">
                        <div>
                            {{--  Status --}}
                            <x-forms.select name="status" label="Status">
                                <option class="bg-gray-950 text-white" value="">
                                    Select Status ...
                                </option>

                                @foreach (\App\Enums\RepairStatus::cases() as $type)
                                    <option value="{{ $type->value }}">
                                        {{ $type->value }}
                                    </option>
                                @endforeach
                            </x-forms.select>
                            <x-forms.error-message name="status" />
                        </div>

                        <div>
                            {{-- imei  --}}
                            <x-forms.input name="imei" :value="old('imei')" label="Imei" />
                            <x-forms.error-message name="imei" />
                        </div>
                        <div>
                            {{-- SN  --}}
                            <x-forms.input name="sn" :value="old('sn')" label="Serial Number" />
                            <x-forms.error-message name="sn" />
                        </div>

                    </div>





                    {{-- technician_note --}}
                    <div class="mt-5 text-white">
                        <label for="technician_note" class="block mb-2.5 text-sm font-medium text-heading">
                            technician note</label>
                        <textarea id="technician_note" rows="2" name="technician_note"
                            class="bg-neutral-secondary-medium text-black border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                            placeholder="Write technician note  here..."></textarea>
                        <x-forms.error-message name="technician_note" />

                    </div>


                    {{-- issue_description  --}}
                    <div class="mt-5 text-white">
                        <label for="issue_description" class="block mb-2.5 text-sm font-medium text-heading">Issue
                            Description</label>
                        <textarea id="issue_description" rows="5" name="issue_description"
                            class="bg-neutral-secondary-medium text-black border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                            placeholder="Write issue description here..."></textarea>
                        <x-forms.error-message name="issue_description" />

                    </div>



                    <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2">
                        <div>
                            {{-- device_access_info  --}}
                            <x-forms.input name="device_access_info" :value="old('device_access_info')" label="Access Information"
                                placeholder="PIN: 1234, Pattern: L Shape .." />
                            <x-forms.error-message name="device_access_info" />
                        </div>
                        <div>
                            {{--  estimated_price --}}
                            <x-forms.input name="estimated_price" :value="old('estimated_price')" label="Estimated Price (Euro)"
                                placeholder=" Price " />
                            <x-forms.error-message name="estimated_price" />
                        </div>
                    </div>


                    {{-- received_at  --}}
                    <div class="mt-2">
                        <label for="received_at" class="block mb-2.5 text-white text-sm font-medium text-heading">
                            Received At
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                </svg>
                            </div>

                            <input type="datetime-local" id="received_at" name="received_at"
                                value="{{ old('received_at', now()->format('Y-m-d\TH:i')) }}"
                                class="block w-full ps-10 pe-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs">
                        </div>
                        <x-forms.error-message name="received_at" />
                    </div>
                </div>
                {{-- Actions  --}}
                <div>
                    <div class="mt-2 flex items-center justify-end gap-x-6">
                        <a href="{{ route('repair-tickets.index') }}" type="button"
                            class="text-sm/6 font-semibold text-white">Cancel</a>
                        <button type="submit"
                            class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                    </div>
                </div>

        </form>
    </div>
@endsection
