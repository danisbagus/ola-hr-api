<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'email' => 'danis@live.com',
                'password' => '$2y$12$an8lY/AaQGX75YTEp9XMF.wNPT7RWLxPkgH6nwmi6mKAB4gd5c4UC',
                'role_id' => 1,
                'is_active' => true,
                'created_at' => now(),
            ],
        ]);
    }
}
