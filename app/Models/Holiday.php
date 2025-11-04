<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Holiday extends Model
{
    use HasFactory;

    // Table name (optional)
    protected $table = 'holidays';

    // Fillable columns
    protected $fillable = [
        'name',
        'date',
        'day',
    ];

    // Automatically cast date to Carbon
    protected $casts = [
        'date' => 'date',
    ];

    // Automatically get the day name if not stored in DB
    public function getDayAttribute($value)
    {
        return $value ?: Carbon::parse($this->date)->format('l');
    }
}
