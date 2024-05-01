<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_attendence_time extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'in_time',
        'out_time',
        'total_hours',
        'login_status'
       
    ];

}
