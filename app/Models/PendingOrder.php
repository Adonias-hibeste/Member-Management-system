<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tx_ref', 'total_amount', 'customer_info'];

    protected $casts = [
        'customer_info' => 'array',
    ];
}
