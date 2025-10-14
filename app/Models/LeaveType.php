<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    public $fillable = ['name', 'default_days', 'requires_approval'];

    public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class);
    }
    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

}
