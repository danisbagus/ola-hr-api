<?php

namespace App\Http\Requests;

use App\Http\DataTransferObjects\EmployeeData;
use App\Http\DataTransferObjects\UserData;

class StoreEmployeeRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'employment_status' => ['required', 'in:PERMANENT,CONTRACT,INTERNSHIP'],
            'gender' => ['required', 'in:MALE,FEMALE'],
            'hire_date' => ['nullable', 'date'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'division_id' => ['required', 'exists:divisions,id'],
            'role_id' => ['required', 'exists:roles,id'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function toEmployeeDto(int $userId, string $employeeNumber): EmployeeData
    {
        return new EmployeeData(
            name: $this->input('name'),
            userId: $userId,
            divisionId: $this->input('division_id'),
            employeeNumber: $employeeNumber,
            phoneNumber: $this->input('phone_number'),
            employmentStatus: $this->input('employment_status'),
            gender: $this->input('gender'),
            hireDate: $this->input('hire_date'),
            birthDate: $this->input('birth_date'),
            address: $this->input('address'),
            isActive: $this->boolean('is_active'),
        );
    }

    public function toUserDto(string $generatedPassword): UserData
    {
        return new UserData(
            email: $this->input('email'),
            password: $generatedPassword,
            roleId: $this->input('role_id'),
            isActive: true,
        );
    }
}
