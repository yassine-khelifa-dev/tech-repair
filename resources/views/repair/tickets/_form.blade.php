@extends('layouts.admin')

@section('content')
    <div x-data="{
        devicetypes: {{ Js::from($devicetypes) }},
        brands: {{ Js::from($brands) }},
        device_type_selected_id: '{{ old('device_type_id', $repair_ticket->deviceModel->type->id ?? -1) }}',
        brand_selected_id: '{{ old('brand_id', $repair_ticket->deviceModel->brand->id ?? -1) }}',
        device_model_selected_id: '{{ old('device_model_id', $repair_ticket->deviceModel->id ?? -1) }}',
        status: '{{ old('status', $repair_ticket->status ?? -1) }}',
        selected_option_ids: {{ Js::from(old('selected_option_ids', $selected_option_ids ?? [])) }},
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
        get device_model_selected() {
            return this.getDeviceModel.find(
                m => String(m.id) === String(this.device_model_selected_id)
            ) ?? null
        },
        get getOptions() {
            //allowed_options
            const options = {}
            if (!this.device_model_selected) return {}

            this.device_model_selected.allowed_options.forEach(el => {
                const id = el.id
                const key = el.spec_attribute.name;
                const value = el.value;
                if (!options[key]) {
                    options[key] = []
                }

                options[key].push({ id, value })
            });
            return options ?? [];
        }
    }">
        {{-- Form  --}}
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($method == 'PUT')
                @method('PUT')
            @endif
            <div class="space-y-12">
                {{--  Errors Form --}}
                @if ($errors->any())
                    <div class="text-red-500">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="border-b border-white/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-white">
                        @if ($mode == 'edit')
                            Edit Ticket
                        @else
                            Create Ticket
                        @endif
                    </h2>
                    <p class="mt-1 text-sm/6 text-gray-400">Use a permanent address where you can receive mail.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-3">
                        <div>
                            {{-- full name  --}}
                            <x-forms.input name="fullname" :value="old('fullname', $repair_ticket->customer->fullname ?? '')" label="Full Name" />
                            <x-forms.error-message name="fullname" />
                        </div>
                        <div>
                            {{-- phone  --}}
                            <x-forms.input name="phone" :value="old('phone', $repair_ticket->customer->phone ?? '')" label="Your number phone" />
                            <x-forms.error-message name="phone" />
                        </div>
                        <div>
                            {{-- email  --}}
                            <x-forms.input name="email" :value="old('email', $repair_ticket->customer->email ?? '')" label="Email" />
                            <x-forms.error-message name="email" />
                        </div>
                    </div>
                    <div>

                        {{-- Device Types --}}
                        <div class="mt-5 text-white">
                            <x-forms.select name="device_type_id" label="Select Types" model="device_type_selected_id">
                                <option class="bg-black text-white" value="-1">Select value ...</option>
                                <template x-for="devicetype in devicetypes" :key="devicetype.id">
                                    <option class="bg-black text-white" :value="devicetype.id" x-text="devicetype.name"
                                        :selected="devicetype.id == device_type_selected_id">
                                    </option>
                                </template>
                            </x-forms.select>
                            <x-forms.error-message name="device_type_id" />
                        </div>

                        {{--  Brand  --}}
                        <div class="mt-5 text-white">
                            <x-forms.select name="brand_id" label="Select a Brand" model="brand_selected_id">
                                <option class="bg-black text-white" value="-1">Select value ...</option>
                                <template x-for="brand in brands" :key="brand.id">
                                    <option class="bg-black text-white" :value="brand.id" x-text="brand.name"
                                        :selected="brand.id == brand_selected_id">
                                    </option>
                                </template>
                            </x-forms.select>
                            <x-forms.error-message name="brand_id" />
                        </div>
                    </div>



                    {{--  Models --}}
                    <template x-if="brand_selected_id != -1 && device_type_selected_id != -1">
                        <div class="mt-5 text-white">
                            <x-forms.select name="device_model_id" label="Select a Device Model"
                                model="device_model_selected_id">
                                <option class="bg-black text-white" value="-1">Select value ...</option>
                                <template x-for="device_model in getDeviceModel" :key="device_model.id">
                                    <option class="bg-black text-white" :value="device_model.id" x-text="device_model.name"
                                        :selected="device_model.id == device_model_selected_id">
                                    </option>
                                </template>
                            </x-forms.select>
                            <x-forms.error-message name="device_model_id" />
                        </div>
                    </template>


                    {{-- Options --}}
                    <template x-if="device_model_selected_id != -1">
                        <div class="text-white">
                            <h1>Options Allow :</h1>
                            <template x-for="(options, key) in getOptions" :key="key">
                                <div>
                                    <h1 class="text-blue-400" x-text="key"></h1>
                                    <template x-for="item in options" :key="item.id">
                                        <div class="flex items-center mb-4">
                                            <input :id="'option_' + item.id" type="radio" :value="item.id"
                                                :name="'selected_option_ids[' + key + ']'" x-model="selected_option_ids[key]"
                                                class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
                                            <label :for="'option_' + item.id"
                                                class="select-none ms-2 text-sm font-medium text-heading">
                                                <span x-text="item.value"> </span> </label>
                                        </div>
                                    </template>
                                    <hr />
                                </div>
                            </template>
                        </div>
                    </template>
                    {{-- end Options --}}



                    {{--  Detail SN, IEMI - Status --}}
                    <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-3">
                        <div>
                            {{--  Status --}}
                            <x-forms.select name="status" model="status" label="Status">
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
                            <x-forms.input name="imei" :value="old('imei', $repair_ticket->imei ?? '')" label="Imei" />
                            <x-forms.error-message name="imei" />
                        </div>
                        <div>
                            {{-- SN  --}}
                            <x-forms.input name="sn" :value="old('sn', $repair_ticket->sn ?? '')" label="Serial Number" />
                            <x-forms.error-message name="sn" />
                        </div>
                    </div>

                    {{-- technician_note --}}
                    <div class="mt-5 text-white">
                        <label for="technician_note" class="block mb-2.5 text-sm font-medium text-heading">
                            technician note</label>
                        <textarea id="technician_note" rows="2" name="technician_note"
                            class="bg-neutral-secondary-medium text-black border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                            placeholder="Write technician note  here...">{{ old('technician_note', $repair_ticket->technician_note ?? '') }}</textarea>
                        <x-forms.error-message name="technician_note" />
                    </div>

                    {{-- issue_description  --}}
                    <div class="mt-5 text-white">
                        <label for="issue_description" class="block mb-2.5 text-sm font-medium text-heading">Issue
                            Description</label>
                        <textarea id="issue_description" rows="5" name="issue_description"
                            class="bg-neutral-secondary-medium text-black border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                            placeholder="Write issue description here...">{{ old('issue_description', $repair_ticket->issue_description ?? '') }}</textarea>
                        <x-forms.error-message name="issue_description" />
                    </div>

                    <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2">
                        <div>
                            {{-- device_access_info  --}}
                            <x-forms.input name="device_access_info"
                                value="{{ old('device_access_info', $repair_ticket->device_access_info ?? '') }}"
                                label="Access Information" placeholder="PIN: 1234, Pattern: L Shape .." />
                            <x-forms.error-message name="device_access_info" />
                        </div>
                        <div>
                            {{--  estimated_price --}}
                            <x-forms.input name="estimated_price"
                                value="{{ old('estimated_price', $repair_ticket->estimated_price ?? '') }}"
                                label="Estimated Price (Euro)" placeholder=" Price " />
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
                                value="{{ old('received_at', $repair_ticket->received_at ?? now()->format('Y-m-d\TH:i')) }}"
                                class="block w-full ps-10 pe-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs">
                        </div>
                        <x-forms.error-message name="received_at" />
                    </div>
                </div>


                {{-- images  --}}
                 <x-forms.upload_images name="images_device" />

                {{-- Actions  --}}
                <div>
                    <div class="mt-2  mr-5 flex items-center justify-end gap-x-6">
                        <a href="{{ route('repair-tickets.index') }}" type="button"
                            class="text-sm/6 font-semibold text-white">Cancel</a>
                        <button type="submit" @class([
                            'bg-indigo-500 ' => $mode == 'create',
                            'bg-red-500' => $mode == 'edit',
                            'rounded-md  px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500',
                        ])>
                            @if ($mode == 'edit')
                                Edit
                            @else
                                Save
                            @endif
                        </button>
                    </div>
                </div>
        </form>
    </div>
@endsection
