<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_days_per_year',
        'carry_forward',
        'description',
        'status',
    ];

    protected $casts = [
        'carry_forward' => 'boolean',
        'total_days_per_year' => 'integer',
    ];
}
