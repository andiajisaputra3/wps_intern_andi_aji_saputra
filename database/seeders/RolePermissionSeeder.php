<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        Role::create(['name' => 'direktur']);
        Role::create(['name' => 'manager operasional']);
        Role::create(['name' => 'manager keuangan']);
        Role::create(['name' => 'staff operasional']);
        Role::create(['name' => 'staff keuangan']);

        Permission::create(['name' => 'create masterdata']);
        Permission::create(['name' => 'edit masterdata']);
        Permission::create(['name' => 'delete masterdata']);

        $admin->givePermissionTo([
            'create masterdata',
            'edit masterdata',
            'delete masterdata'
        ]);
    }
}
