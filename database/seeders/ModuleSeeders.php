<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModuleSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Module Parent
        $parentModules = [
            [
                'id' => 1,
                'title' => 'Organization',
                'code' => 'organization',
                'path' => '/organization',
                'parent_id' => null,
                'icon' => 'OfficeBuilding',
                'rank' => 1,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'title' => 'Attendance',
                'code' => 'attendance',
                'path' => '/attendance',
                'parent_id' => null,
                'icon' => 'Calendar',
                'rank' => 2,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'title' => 'Payroll',
                'code' => 'payroll',
                'path' => '/payroll',
                'parent_id' => null,
                'icon' => 'Money',
                'rank' => 3,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'title' => 'Performance',
                'code' => 'performance',
                'path' => '/performance',
                'parent_id' => null,
                'icon' => 'Monitor',
                'rank' => 4,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('modules')->insert($parentModules);

        $childModules = [
            [
                'id' => 5,
                'title' => 'Employee Management',
                'code' => 'employee_management',
                'path' => '/organization/employee-management',
                'parent_id' => 1,
                'icon' => 'User',
                'rank' => 1,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'title' => 'Division Management',
                'code' => 'division_management',
                'path' => '/organization/division-management',
                'parent_id' => 1,
                'icon' => 'School',
                'rank' => 2,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'title' => 'Role Management',
                'code' => 'role_management',
                'path' => '/organization/role-management',
                'parent_id' => 1,
                'icon' => 'Lock',
                'rank' => 3,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'title' => 'Attendance Tracking',
                'code' => 'attendance_tracking',
                'path' => '/attendance/attendance-tracking',
                'parent_id' => 2,
                'icon' => 'Clock',
                'rank' => 1,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'title' => 'Leave Management',
                'code' => 'leave_management',
                'path' => '/attendance/leave-management',
                'parent_id' => 2,
                'icon' => 'Suitcase',
                'rank' => 1,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'title' => 'Salary Management',
                'code' => 'salary_management',
                'path' => '/payroll/salary-management',
                'parent_id' => 3,
                'icon' => 'Wallet',
                'rank' => 1,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 11,
                'title' => 'Performance Management',
                'code' => 'performance_management',
                'path' => '/performance/performance-management',
                'parent_id' => 4,
                'icon' => 'TrendCharts',
                'rank' => 1,
                'is_hide' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('modules')->insert($childModules);
    }
}
