<?php

namespace App\Http\Requests;

use App\Http\DataTransferObjects\RoleData;

class StoreRoleRequest extends BaseFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'module_ids' => 'required|array|min:1',
            'module_ids.*' => 'exists:modules,id',
        ];
    }

    public function toDto()
    {
        return new RoleData(
            name: $this->input('name'),
            isActive: $this->input('is_active'),
        );
    }
}
