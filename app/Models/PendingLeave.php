<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'remaining',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
}
