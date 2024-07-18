<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task_time extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'task_id',
        'start_time',
        'end_time',
        'total_time',
        'status'
      ];


}
