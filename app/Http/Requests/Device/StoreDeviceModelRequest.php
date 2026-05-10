<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceModelRequest extends FormRequest
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
            'name' => 'required|min:5|max:255|unique:device_models,name',
            'brand_id' => 'required|integer|exists:brands,id',
            'type_id' => 'required|integer|exists:device_types,id'
        ];
    }
}
