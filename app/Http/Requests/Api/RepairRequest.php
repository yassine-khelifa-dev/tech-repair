<?php

namespace App\Http\Requests\Api;

use App\Enums\RepairRequestStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'phone'             => 'required|integer',
            'email'             => 'required|email|max:255',
            'imei'              => 'nullable|regex:/^[a-zA-Z0-9]+$/',
            'sn'                => 'nullable|regex:/^[a-zA-Z0-9]+$/',
            'issue_description' => 'required|min:10',
            'device_model_id'   => 'required|exists:device_models,id',
            'option_ids'        => "required|array|min:1",
            'option_ids.*'      => 'integer|exists:spec_attribute_options,id',
            'status'            => Rule::enum(RepairRequestStatus::class),
            'images_device' => ['nullable', 'array'],
            'images_device.*' => ['image', 'max:5120'],
        ];
    }
}
