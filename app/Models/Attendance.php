<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'duration_minutes',
    ];

    // Relation to User (Employee)
   public function employee()
{
    // 'user_id' is the foreign key in attendances table pointing to users.id
    return $this->belongsTo(User::class, 'user_id');
}
}
