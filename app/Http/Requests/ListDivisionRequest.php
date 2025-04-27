<?php

namespace App\Http\Requests;

class ListDivisionRequest extends BasePaginationRequest
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
            'is_active' => 'nullable|boolean',
            'keyword' => 'nullable|string|max:255',
        ]);
    }

    public function getFilters(): array
    {
        return [
            'is_active' => $this->has('is_active') ? (bool) $this->input('is_active') : null,
            'keyword' => $this->input('keyword', ''),
        ];
    }
}
