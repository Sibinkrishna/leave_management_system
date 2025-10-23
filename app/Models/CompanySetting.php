<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    public $fillable = ['company_name', 'address', 'phone', 'email', 'website', 'logo'];
}