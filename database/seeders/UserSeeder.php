<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create role
        $superAdmin = Role::create(['name' => 'Super-Admin']);
        $admin = Role::create(['name' => 'admin']);
        $managemen = Role::create(['name' => 'managemen']);

        //create permission
        Permission::create(['name' => 'create data']);
        Permission::create(['name' => 'read data']);
        Permission::create(['name' => 'update data']);
        Permission::create(['name' => 'delete data']);

        $admin->givePermissionTo(['create data', 'read data', 'update data', 'delete data']);
        $managemen->givePermissionTo('read data');

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'super',
            'last_name' => 'Admin',
            'email' => 'superadmin@gmail.com',
        ]);
        $user->assignRole($superAdmin);

        $user = \App\Models\User::factory()->create([
            'name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
        $user->assignRole($admin);

        $user = \App\Models\User::factory()->create([
            'name' => 'managemen',
            'last_name' => 'managemen',
            'email' => 'managemen@gmail.com',
        ]);
        $user->assignRole($managemen);
    }
}
