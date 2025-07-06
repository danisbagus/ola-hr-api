<?php

namespace App\Http\DataTransferObjects;

use App\Models\Employee;
use Carbon\Carbon;

class EmployeeData
{
    public function __construct(
        public string $name,
        public int $userId,
        public int $divisionId,
        public string $employeeNumber,
        public ?string $phoneNumber,
        public string $employmentStatus, // e.g. 'PERMANENT'
        public string $gender,           // 'MALE' or 'FEMALE'
        public ?string $hireDate,        // format: 'YYYY-MM-DD'
        public ?string $birthDate,       // format: 'YYYY-MM-DD'
        public ?string $address,
        public bool $isActive,
    ) {}

    public function toModel(): Employee
    {
        return new Employee([
            'name' => $this->name,
            'user_id' => $this->userId,
            'division_id' => $this->divisionId,
            'employee_number' => $this->employeeNumber,
            'phone_number' => $this->phoneNumber,
            'employment_status' => $this->employmentStatus,
            'gender' => $this->gender,
            'hire_date' => $this->hireDate ? Carbon::parse($this->hireDate) : null,
            'birth_date' => $this->birthDate ? Carbon::parse($this->birthDate) : null,
            'address' => $this->address,
            'is_active' => $this->isActive,
            'created_at' => now(),
        ]);
    }
}
