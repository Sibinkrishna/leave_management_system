<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypesSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            ['name' => 'Casual Leave', 'total_days_per_year' => 12, 'carry_forward' => 1, 'description' => 'Leave for personal reasons.'],
            ['name' => 'Sick Leave', 'total_days_per_year' => 10, 'carry_forward' => 0, 'description' => 'Leave for illness.'],
            ['name' => 'Medical Leave', 'total_days_per_year' => 15, 'carry_forward' => 1, 'description' => 'Leave earned over the year.'],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::create($type);
        }
    }
}
