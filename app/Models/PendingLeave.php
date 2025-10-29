<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\leaveType;

class PendingLeave extends Model
{
    use HasFactory;
    protected $table = 'pending_leaves';

    protected $fillable = [
         'employee_id',
        'leave_type_id',
        'total_days',
        'used_days',
        'remaining_days',
    ];

    // Relationship with User model
    public function employee()
    {
        return $this->belongsTo(User::class);
    }
     public function leaveType()
    {
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }
}
