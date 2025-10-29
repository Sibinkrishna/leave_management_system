<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leaves';

    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'admin_comment',
        'approved_by',
    ];

    public function employee()
    {
        // Correct namespace for User model
        return $this->belongsTo(\App\Models\User::class, 'employee_id');
    }
}
