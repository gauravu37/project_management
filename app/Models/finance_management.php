<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finance_management extends Model
{
    use HasFactory;
    protected $fillable = [
       'project_name',
        'amount',
        'tds_deduct',
        'actual_amount',
       'date',
       'gst_recieved',
        'invoice_number',
        'invoice_amount'

        
    ];
}
