<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate([
            'name' => 'create_user',
            'guard_name' => 'web',
            'group_name' => 'user',
        ]);
        Permission::firstOrCreate([
            'name' => 'view_user',
            'guard_name' => 'web',
            'group_name' => 'user',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit_user',
            'guard_name' => 'web',
            'group_name' => 'user',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete_user',
            'guard_name' => 'web',
            'group_name' => 'user',
        ]);
        Permission::firstOrCreate([
            'name' => 'print_user',
            'guard_name' => 'web',
            'group_name' => 'user',
        ]);
        Permission::firstOrCreate([
            'name' => 'import_user',
            'guard_name' => 'web',
            'group_name' => 'user',
        ]);
        Permission::firstOrCreate([
            'name' => 'export_user',
            'guard_name' => 'web',
            'group_name' => 'user',
        ]);
        Permission::firstOrCreate([
            'name' => 'create_permission',
            'guard_name' => 'web',
            'group_name' => 'permission',
        ]);
        Permission::firstOrCreate([
            'name' => 'view_permission',
            'guard_name' => 'web',
            'group_name' => 'permission',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit_permission',
            'guard_name' => 'web',
            'group_name' => 'permission',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete_permission',
            'guard_name' => 'web',
            'group_name' => 'permission',
        ]);
        Permission::firstOrCreate([
            'name' => 'print_permission',
            'guard_name' => 'web',
            'group_name' => 'permission',
        ]);
        Permission::firstOrCreate([
            'name' => 'import_permission',
            'guard_name' => 'web',
            'group_name' => 'permission',
        ]);
        Permission::firstOrCreate([
            'name' => 'export_permission',
            'guard_name' => 'web',
            'group_name' => 'permission',
        ]);
        Permission::firstOrCreate([
            'name' => 'create_role',
            'guard_name' => 'web',
            'group_name' => 'role',
        ]);
        Permission::firstOrCreate([
            'name' => 'view_role',
            'guard_name' => 'web',
            'group_name' => 'role',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit_role',
            'guard_name' => 'web',
            'group_name' => 'role',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete_role',
            'guard_name' => 'web',
            'group_name' => 'role',
        ]);
        Permission::firstOrCreate([
            'name' => 'print_role',
            'guard_name' => 'web',
            'group_name' => 'role',
        ]);
        Permission::firstOrCreate([
            'name' => 'import_role',
            'guard_name' => 'web',
            'group_name' => 'role',
        ]);
        Permission::firstOrCreate([
            'name' => 'export_role',
            'guard_name' => 'web',
            'group_name' => 'role',
        ]);
        $adminRole = Role::where('name', 'admin')->first();
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);
    }
}
