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
        Permission::create(['name' => 'view_users','guard_name' => 'admin']);
        Permission::create(['name'=> 'add_users','guard_name' => 'admin']);
        Permission::create(['name'=>'edit_user','guard_name' => 'admin']);
        Permission::create(['name'=> 'delete_user','guard_name' => 'admin']);

        //Role managment
        Permission::create(['name'=> 'view_roles','guard_name' => 'admin']);
        Permission::create(['name'=> 'add_roles','guard_name' => 'admin']);
        Permission::create(['name'=> 'edit_role','guard_name' => 'admin']);
        Permission::create(['name'=> 'delete_role','guard_name' => 'admin']);
    }
}
