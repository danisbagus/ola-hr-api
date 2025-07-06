<?php

namespace App\Http\Requests;

class UpdateEmployeeRequest extends BaseFormRequest
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
            'phone_number' => 'nullable|string|max:20',
            'employment_status' => 'required|in:PERMANENT,CONTRACT,INTERNSHIP',
            'gender' => 'required|in:MALE,FEMALE',
            'division_id' => 'required|exists:divisions,id',
            'role_id' => 'required|exists:roles,id',
            'address' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];
    }
}
