<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Validation\Rule;

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
            'hire_date' => 'nullable|date',
            'birth_date' => 'nullable|date',
        ];
    }

    public function withValidator($validator)
    {
        $employee = Employee::find($this->route('id'));

        if ($employee && $employee->user_id) {
            $validator->sometimes('email', [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($employee->user_id),
            ], function () {
                return true;
            });
        }
    }
}
