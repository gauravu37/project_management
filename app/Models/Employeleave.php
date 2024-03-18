<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeleave extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'date',
        'reason',
        'status',
    ];
}
