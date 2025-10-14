<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    public $fillable = ['user_id', 'leave_type_id', 'start_date', 'end_date', 'reason', 'status', 'approved_by', 'approval_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
    public function getDurationAttribute()
    {
        return $this->days . ' days';
    }

}
