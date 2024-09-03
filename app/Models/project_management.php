<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project_management extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'client_name',
        'assign',
        'total_hours',
        'payment',
        'deadline',
        'description',
        'logindetail',
        'upwork_url',
        'asana_url',
        'development_url',
        'live_url',
        'status'
        
        
    ];

}
///