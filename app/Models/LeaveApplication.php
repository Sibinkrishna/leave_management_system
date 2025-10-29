<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'subject',
        'reason',
        'days',
        'status',
        'approved_by',
        'approval_date'
    ];

    /**
     * Relation to the user who applied for leave
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation to the leave type
     */
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    /**
     * Relation to the approver (if approved)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Accessor for status label
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Accessor for formatted duration
     */
    public function getDurationAttribute()
    {
        return $this->days ? $this->days . ' day' . ($this->days > 1 ? 's' : '') : '-';
    }
}
