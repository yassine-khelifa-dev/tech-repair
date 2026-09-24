<?php

namespace App\Http\Requests\Api;

use App\Models\DeviceModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RepairRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname'          => 'required|min:3|max:255|regex:/^[\pL\s]+$/u',
            'phone' => [
                'required',
                'regex:/^[0-9]+$/',
                'min:8',
                'max:20',
            ],
            'email'             => 'required|email|max:255',
            'imei'              => 'nullable|regex:/^[a-zA-Z0-9]+$/',
            'sn'                => 'nullable|regex:/^[a-zA-Z0-9]+$/',
            'issue_description' => 'required|min:10',
            'device_model_id'   => 'required|exists:device_models,id',
            'option_ids'        => "required|array|min:1",
            'option_ids.*'      => 'integer|exists:spec_attribute_options,id',
            'images_device' => ['nullable', 'array'],
            'images_device.*' => ['image', 'max:5120'],
        ];
    }


    public function after(): array
    {

        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $device_model = DeviceModel::find($this->device_model_id);
                $check = $device_model->hasOptions($this->option_ids);

                if (! $check) {
                    $validator->errors()->add(
                        'option_ids',
                        'One or more selected options are not allowed for this device model.'
                    );
                }
            }
        ];
    }
}
