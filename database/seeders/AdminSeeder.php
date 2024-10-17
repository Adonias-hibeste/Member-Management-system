<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admin= Admin::create([

            'full_name' => 'admin',
            'gender'=>'test',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'phone'=>'0123456789',
            'address'=>'addis abeba',
            'password' =>  bcrypt('12345678'),

        ]);

        $admin->assignRole('admin');


        // $user=User::create([
        //     'full_name' => 'user',
        //     'email' => 'user@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' =>  bcrypt('12345678'),
        // ]);
        // $user->assignRole('member');
    }
}
