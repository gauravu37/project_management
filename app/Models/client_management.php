<?php

namespace App\Models;
///
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client_management extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'facebook_id',
        'instagram_id',
        'skype_id',
        'telegram_id',
        'whatsapp',
        'upwork_id',
        'project_url',
        'assana',
        'status'
        
    ];

}
