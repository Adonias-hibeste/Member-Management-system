<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view_users']);
        Permission::create(['name'=> 'add_users']);
        Permission::create(['name'=>'edit_user']);
        Permission::create(['name'=> 'delete_user']);

        //Role managment
        Permission::create(['name'=> 'view_roles']);
        Permission::create(['name'=> 'add_roles']);
        Permission::create(['name'=> 'edit_role']);
        Permission::create(['name'=> 'delete_role']);
    }
}
