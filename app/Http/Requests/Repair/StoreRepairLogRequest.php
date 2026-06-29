<?php

namespace App\Http\Requests\Repair;

use App\Enums\RepairStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRepairLogRequest extends FormRequest
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
            'message' => 'required|min:2',
            'new_status' => ['required', Rule::enum(RepairStatus::class)],
            'is_visible_to_customer' => ['required', 'in:0,1'],
            'images_log' => ['nullable', 'array'],
            'images_log.*' => ['image', 'max:5120'],
        ];
    }
}
