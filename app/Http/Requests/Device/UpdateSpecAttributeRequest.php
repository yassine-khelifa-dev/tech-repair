<?php

namespace App\Http\Requests\Device;

use App\Enums\SpecUnit;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSpecAttributeRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'code' => 'required|min:2|max:20',
            'unit' => Rule::enum(SpecUnit::class),
            'input_type' => ['required', Rule::in(['select'])],
            'sort_order' => 'required|integer',
            'devicetypes' => 'required|array|min:1',
            'devicetypes.*' => 'exists:device_types,id',
            'spec_options' => 'required|array|min:1',
        ];
    }
}
