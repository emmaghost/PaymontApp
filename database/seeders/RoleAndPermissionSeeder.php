<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Definir permisos específicos
        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'manage videos']);
        Permission::create(['name' => 'approve comments']);
        Permission::create(['name' => 'view statistics']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view courses']);
        Permission::create(['name' => 'register in courses']);
        Permission::create(['name' => 'comment on videos']);
        Permission::create(['name' => 'like videos']);
        Permission::create(['name' => 'track progress']);

        // Crear rol de administrador y asignar permisos
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'manage courses',
            'manage videos',
            'approve comments',
            'view statistics',
            'manage users'
        ]);

        // Crear rol de usuario y asignar permisos
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view courses',
            'register in courses',
            'comment on videos',
            'like videos',
            'track progress'
        ]);
    }
}
