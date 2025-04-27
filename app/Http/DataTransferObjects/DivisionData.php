<?php

namespace App\Http\DataTransferObjects;

use App\Models\Division;

class DivisionData
{
    public function __construct(
        public string $name,
        public bool $isActive,
    ) {}

    public function toModel(): Division
    {
        $now = now();

        return new Division([
            'name' => $this->name,
            'is_active' => $this->isActive,
            'created_at' => $now
        ]);
    }
}
