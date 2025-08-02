<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleModuleSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_modules')->insert([
            ['role_id' => 1, 'module_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'module_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'module_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'module_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'module_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'module_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'module_id' => 11, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('role_modules')->insert([
            ['role_id' => 2, 'module_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'module_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'module_id' => 11, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
