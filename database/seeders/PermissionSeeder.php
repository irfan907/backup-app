<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::destroy(Permission::pluck('id'));
        
        Permission::create(['name' => 'users-view']);
        Permission::create(['name' => 'users-add']);
        Permission::create(['name' => 'users-edit']);
        Permission::create(['name' => 'users-delete']);

        Permission::create(['name' => 'roles-view']);
        Permission::create(['name' => 'roles-add']);
        Permission::create(['name' => 'roles-edit']);
        Permission::create(['name' => 'roles-delete']);

        $super_admin=Role::updateOrCreate(['name'=>'SuperAdmin']);

        $user=User::updateOrCreate(
            ['email'=>'superadmin@gmail.com'],
            [
            'name'=>'Super Admin',
            'password'=>Hash::make('admin')
            ]);

        $user->syncRoles($super_admin);
    }
}
