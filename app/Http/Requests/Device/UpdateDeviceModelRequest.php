<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDeviceModelRequest extends FormRequest
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
            'name' => [
            'required',
            'min:5',
            'max:255',
            Rule::unique('device_models', 'name')
                ->ignore($this->route('devicemodel')->id),
            ],
            'brand_id' => 'required|integer|exists:brands,id',
            'device_type_id' => 'required|integer|exists:device_types,id'
        ];
    }
}
