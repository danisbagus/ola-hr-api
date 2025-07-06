<?php

namespace App\Http\DataTransferObjects;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserData
{
    public function __construct(
        public string $email,
        public string $password,
        public int $roleId,
        public bool $isActive,
    ) {}

    public function toModel(): User
    {
        return new User(attributes: [
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $this->roleId,
            'is_active' => $this->isActive,
            'created_at' => now(),
        ]);
    }
}
