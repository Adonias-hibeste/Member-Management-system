<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admin_role= Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        Role::create(['name'=>'member']);
        $admin_role->givePermissionTo(Permission::all());

    }
}
