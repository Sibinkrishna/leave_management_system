<?php

namespace App\Models;

use App\Models\PendingLeave;
use App\Models\LeaveApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function pendingLeaves()
    {
        return $this->hasMany(PendingLeave::class, 'leave_type_id');
    }

     public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class,'leave_type_id');
    }
}