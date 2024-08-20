<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'is_admin',
    ];

    public function isAdmin()
    {
        return $this->is_admin == 1;
    }
}
