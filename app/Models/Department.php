<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // Specify the actual table name
    protected $table = 'departments';

    protected $fillable = [
        'name',
        'status',
    ];
}
