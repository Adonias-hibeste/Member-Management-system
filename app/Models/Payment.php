<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_name',
        'membership_type',
        'payment_method',
        'phone_number',
        'bank_name',
        'account_number',
        'amount',
    ];
}
