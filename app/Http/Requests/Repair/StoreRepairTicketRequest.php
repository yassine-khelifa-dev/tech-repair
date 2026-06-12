<?php

namespace App\Http\Requests\Repair;

use App\Enums\RepairStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRepairTicketRequest extends FormRequest
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
            'device_access_info' => 'nullable|max:255',
            'technician_note'   => 'required|min:5',
            'imei'              => 'nullable|regex:/^[a-zA-Z0-9]+$/',
            'sn'                => 'nullable|regex:/^[a-zA-Z0-9]+$/',
            'issue_description' => 'required|min:10',
            'email'             => 'required|email|max:255',
            'device_model_id'   => 'required|exists:device_models,id',
            'brand_id'          => 'required|exists:brands,id',
            'attributes'        => "required|array|min:1",
            'attributes.*'      => 'integer|exists:spec_attribute_options,id',
            'status'            => Rule::enum(RepairStatus::class),
            'estimated_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'images_device' => ['nullable', 'array'],
            'images_device.*' => ['image', 'max:5120'],
        ];
    }
}
