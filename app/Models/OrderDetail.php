<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable=[
        'order_id',
        'name',
        'email',
        'phone',
        'city',
        'woreda',
        'house_no',
    ];

    public function order(){
        return $this->belongsTo('orders');
    }


}
