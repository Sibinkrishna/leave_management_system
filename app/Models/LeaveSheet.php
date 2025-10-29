<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveSheet extends Model
{
    use HasFactory;

    protected $table = 'leavesheet'; // matches migration table

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'leave_type',
        'total_days',
        'reason',
        'status'
    ];

    protected $dates = ['start_date','end_date'];

    // Relation to Employee
    public function employee()
    {
        return $this->belongsTo(User::class);
    }

}
