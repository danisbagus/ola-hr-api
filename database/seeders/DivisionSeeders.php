<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeders extends Seeder
{
    public function run(): void
    {
        DB::table('divisions')->insert([
            [
                'id' => 1,
                'name' => 'Human Resource',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Information Technology',
                'is_active' => true,
                'created_at' => now(),
            ],
        ]);
    }
}
