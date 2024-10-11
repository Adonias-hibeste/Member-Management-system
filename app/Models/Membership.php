<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        // 'duration',
        'price',
    ];

    public function profile(){
        return $this->hasMany(Profile::class);
    }
}
