<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//
class task_management extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'task_title',
        'description',
        'total_hours',
        'status',
        'deadline'
      ];

}
