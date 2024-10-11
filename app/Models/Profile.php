<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Profile extends Model
{

    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table='profiles';
    protected $fillable=[
    'user_id',
    'membership_id',
    'member_payment_status',
    'membership_endDate',
    'image',
    'age',
    'address',
    'gender',
    'phone_number',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    Public function membership(){
        return $this->belongsTo(Membership::class);
    }
}
