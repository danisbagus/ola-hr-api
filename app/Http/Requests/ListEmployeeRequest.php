<?php

namespace App\Http\Requests;

class ListEmployeeRequest extends BasePaginationRequest
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
        return array_merge(parent::rules(), [
            'division_id' => 'nullable|integer|exists:divisions,id',
            'role_id' => 'nullable|integer|exists:roles,id',
            'gender' => 'nullable|in:MALE,FEMALE',
            'is_active' => 'nullable|boolean',
            'employment_status' => 'nullable|in:PERMANENT,CONTRACT,INTERNSHIP',
            'keyword' => 'nullable|string|max:255',
        ]);
    }

    public function getFilters(): array
    {
        return [
            'division_id' => $this->input('division_id'),
            'role_id' => $this->input('role_id'),
            'gender' => $this->input('gender'),
            'is_active' => $this->has('is_active') ? (bool) $this->input('is_active') : null,
            'employment_status' => $this->input('employment_status'),
            'keyword' => $this->input('keyword', ''),
        ];
    }
}
