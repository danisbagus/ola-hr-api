<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            'name' => 'Danis Bagus',
            'user_id' => 1,
            'division_id' => 1,
            'employee_number' => 'OLA-0001',
            'phone_number' => '08123456789',
            'employment_status' => 'PERMANENT',
            'gender' => 'MALE',
            'hire_date' => Carbon::parse('2023-05-01'),
            'birth_date' => Carbon::parse('1995-06-15'),
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'is_active' => true,
            'created_at' => now(),
        ]);
    }
}
