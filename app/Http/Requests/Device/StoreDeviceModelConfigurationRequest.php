<?php

namespace App\Http\Requests\Device;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceModelConfigurationRequest extends FormRequest
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
            'allowed_options'=>"required|array|min:1",
            'allowed_options.*' => 'integer|exists:spec_attribute_options,id'
        ];
    }
}
