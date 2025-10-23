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
        'type',
        'from_date',
        'to_date',
        'reason',
        'status',
    ];

    // Relationship with User model
    public function employee()
    {
        return $this->belongsTo(employee::class);
    }
}
