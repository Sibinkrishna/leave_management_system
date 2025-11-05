<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkFromHomeEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'entry_date',       // ✅ new column
        'work_time',        // ✅ new column
        'task_summary',
        'notes',
        'pushed_to_sheet',
        'sheet_row_id',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
        'pushed_to_sheet' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
