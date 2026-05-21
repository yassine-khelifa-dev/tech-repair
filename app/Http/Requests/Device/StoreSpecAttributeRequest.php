<?php

namespace App\Http\Requests\Device;

use App\Enums\SpecInputType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSpecAttributeRequest extends FormRequest
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
            'input_type' => Rule::enum(SpecInputType::class),
            'sort_order' => 'required|integer',
            'devicetypes' => 'required|array|min:1',
            'devicetypes.*' => 'exists:device_types,id',
            'list_options' => 'required|array|min:1',
        ];
    }
}
