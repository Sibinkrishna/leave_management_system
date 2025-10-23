<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveSheet extends Model
{
    use HasFactory;

    protected $table = 'leavesheet'; // matches migration table

    protected $fillable = [
        'emp_id',
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
        return $this->belongsTo(Employee::class);
    }
}
