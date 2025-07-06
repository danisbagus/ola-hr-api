<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => optional($this->user)->email,
            'employee_number' => $this->employee_number,
            'employment_status' => $this->employment_status,
            'gender' => $this->gender,
            'division' => optional($this->division)->name,
            'role' => optional($this->user?->role)->name,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Transform the resource into an array for detail.
     *
     * @return array<string, mixed>
     */
    public function toArrayDetail(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => optional($this->user)->email,
            'phone_number' => $this->phone_number,
            'employment_status' => $this->employment_status,
            'gender' => $this->gender,
            'division_id' => $this->division_id,
            'division_name' => optional($this->division)->name,
            'role_id' => optional($this->user)->role_id,
            'role_name' => optional($this->user?->role)->name,
            'hire_date' => $this->hire_date,
            'birth_date' => $this->birth_date,
            'address' => $this->address,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
