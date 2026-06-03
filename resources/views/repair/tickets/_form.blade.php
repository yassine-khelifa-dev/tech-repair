@extends('layouts.admin')

@section('content')
    <div x-data="{
        devicetypes: {{ Js::from($devicetypes) }},
        brands: {{ Js::from($brands) }},
        device_type_selected_id: '{{ old('device_type_id', -1) }}',
        brand_selected_id: '{{ old('brand_id', -1) }}',
        device_model_selected_id: '{{ old('device_model_id', -1) }}',
        device_model_selected: null,

        changeSelect() {
            this.device_model_selected_id = -1;
        },

        get getDeviceModel() {
            const type = this.devicetypes.find(
                t => t.id == this.device_type_selected_id
            );
            const d_models = type?.device_models.filter(
                m => m.brand.id == this.brand_selected_id
            );
            return d_models ?? [];
        },

        get getOptions() {
            //allowed_options

            const options = {}

            this.device_model_selected.allowed_options.forEach(el => {
                const key = el.spec_attribute.name;
                const value = el.value;
                if (!options[key]) {
                    options[key] = []
                }
                options[key].push(value)
            });

            return options ?? [];
        }
    }">



        <form action="{{ $action }}" method="POST">
            @csrf
            @if ($method == 'PUT')
                @method('PUT')
            @endif
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

                        {{--  Type --}}
                        <div class="mt-5 text-white">
                            <label for="device_type_id" class="mb-2.5 block text-sm font-medium text-white">
                                Select a Device Type
                            </label>
                            <select id="device_type_id" name="device_type_id" x-model="device_type_selected_id"
                                @change="changeSelect()"
                                class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">

                                <option class="bg-black text-white" value="-1">
                                    Choose a type
                                </option>

                                <template x-for="devicetype in devicetypes" :key="devicetype.id">
                                    <option class="bg-black text-white" :value="devicetype.id" x-text="devicetype.name"
                                        :selected="devicetype.id == device_type_selected_id">
                                    </option>
                                </template>
                            </select>

                            @error('device_type_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>




                        {{--  Brand  --}}
                        <div class="mt-5 text-white">
                            <label for="brand_id" class="mb-2.5 block text-sm font-medium text-white">
                                Select a Brand
                            </label>
                            <select id="brand_id" name="brand_id" x-model="brand_selected_id" @change="changeSelect()"
                                class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">
                                <option class="bg-black text-white" value="-1">
                                    Choose a brand
                                </option>

                                <template x-for="brand in brands" :key="brand.id">
                                    <option class="bg-black text-white" :value="brand.id" x-text="brand.name"
                                        :selected="brand.id == brand_selected_id">
                                    </option>
                                </template>
                            </select>

                            @error('brand_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    {{--  Models --}}
                    <template x-if="brand_selected_id != -1 && device_type_selected_id != -1">
                        <div class="mt-5 text-white">
                            <label for="device_model_id" class="mb-2.5 block text-sm font-medium text-white">
                                Select a Device Model
                            </label>
                            <select id="device_model_id" name="device_model_id" x-model="device_model_selected_id"
                                class="block w-full rounded-base border border-gray-700 bg-black px-3 py-2.5 text-sm text-white shadow-xs focus:border-blue-500 focus:ring-blue-500">
                                <option class="bg-black text-white" value="-1">
                                    Select a Device Model ...
                                </option>
                                <template x-for="device_model in getDeviceModel" :key="device_model.id">
                                    <option class="bg-black text-white" :value="device_model.id" x-text="device_model.name"
                                        :selected="device_model.id == device_model_selected_id"
                                        @click="device_model_selected = device_model">
                                    </option>
                                </template>
                            </select>

                            @error('device_model_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                    </template>




                    {{-- Options --}}
                    <template x-if="device_model_selected_id != -1">
                        <div class="text-white">
                            <h1>Options Allow :</h1>
                            <template x-for="(value, key) in getOptions" :key="key">
                                <div>
                                    <span x-text="value"> </span> : <span x-text="key"> </span>
                                </div>
                            </template>
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
