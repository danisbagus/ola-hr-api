<?php

namespace App\Http\DataTransferObjects;

use App\Models\Role;

class RoleData
{
    public function __construct(
        public string $name,
        public bool $isActive,
    ) {}

    public function toModel(): Role
    {
        $now = now();

        return new Role([
            'name' => $this->name,
            'is_active' => $this->isActive,
            'is_super_admin' => false,
            'created_at' => $now
        ]);
    }
}
