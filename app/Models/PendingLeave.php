<?php

namespace App\Models;

use App\Models\User;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingLeave extends Model
{
    use HasFactory;
    protected $table = 'pending_leaves';

    protected $fillable = [
        'user_id',
        'leave_type_id',
        'year',
        'total',
        'used',
        'remaining'
    ];

    // Relationship with User model
    public function employee()
    {
        return $this->belongsTo(User::class);
    }
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
}
