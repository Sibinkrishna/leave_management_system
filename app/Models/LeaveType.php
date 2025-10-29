<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveApplication;
use App\Models\PendingLeave;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_days_per_year',
        'carry_forward',
        'description',
        'status',
    ];

    protected $casts = [
        'carry_forward' => 'boolean',
        'total_days_per_year' => 'integer',
    ];

    public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class, 'leave_type_id', 'id');
    }
    public function employeeLeaves()
    {
        return $this->hasMany(PendingLeave::class);
    }
}
