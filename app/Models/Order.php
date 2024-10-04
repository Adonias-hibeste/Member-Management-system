<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'member_id',
        'order_date',
        'payment_status',
        'total_amount'
    ];

     public function order_item(){
        return $this->hasMany(OrderItem::class);
     }

     public function user(){
        return $this->belongsTo(User::class);
     }
}
