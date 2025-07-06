<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDetailResource extends JsonResource
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
            'employee_number' => $this->employee_number,
            'name' => $this->name,
            'email' => optional($this->user)->email,
            'phone_number' => $this->phone_number,
            'employment_status' => $this->employment_status,
            'gender' => $this->gender,
            'division_id' => $this->division_id,
            'division_name' => optional($this->division)->name,
            'role_id' => optional($this->user)->role_id,
            'role_name' => optional($this->user?->role)->name,
            'hire_date' => $this->hire_date->format('Y-m-d'),
            'birth_date' => $this->birth_date->format('Y-m-d'),
            'address' => $this->address,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
