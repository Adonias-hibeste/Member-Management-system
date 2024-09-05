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

        'name',
        'image',
    'place_of_birth',
    'dob',
    'full_address',
    'nationality',

    'gender',
    'email',
    'phone_number',
    'password',
    'membership_type',];
}
