<?php

namespace App\Http\Requests;

class BasePaginationRequest extends BaseFormRequest
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
            'page' => 'nullable|integer|min:1',
            'size' => 'nullable|integer|min:1|max:100',
            'sort_by' => 'nullable|string',
            'sort_order' => 'nullable|in:asc,desc,ASC,DESC',
        ];
    }

    protected function sortByMap(): array
    {
        return [
            'name' => 'name',
            'created_at' => 'created_at',
            'id' => 'id',
        ];
    }


    public function getPagination(): array
    {
        $sortByMap = $this->sortByMap();
        $sortBy = $sortByMap[$this->input('sort_by')] ?? 'name';

        return [
            'page' => $this->input('page', 1),
            'size' => $this->input('size', 10),
            'sort_by' => $sortBy,
            'sort_order' => $this->input('sort_order', 'ASC'),
        ];
    }
}
