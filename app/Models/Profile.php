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
    protected $table='profile';
    protected $fillable=[

    'first_name',
    'last_name',
    'image',
    'age',
    'address',
    'gender',
    'phone_number',
    ];
}
