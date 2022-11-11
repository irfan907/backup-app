<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Permission::truncate();
        DB::statement("SET foreign_key_checks=1");
        
        Permission::create(['name' => 'users-view']);
        Permission::create(['name' => 'users-add']);
        Permission::create(['name' => 'users-edit']);
        Permission::create(['name' => 'users-delete']);

        Permission::create(['name' => 'roles-view']);
        Permission::create(['name' => 'roles-add']);
        Permission::create(['name' => 'roles-edit']);
        Permission::create(['name' => 'roles-delete']);
    }
}
