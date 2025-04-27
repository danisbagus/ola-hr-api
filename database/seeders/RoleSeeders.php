<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Super Admin',
                'is_active' => true,
                'is_super_admin' => true,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'IT Programmer',
                'is_active' => true,
                'is_super_admin' => false,
                'created_at' => now(),
            ],
        ]);
    }
}
