<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Réinitialiser les rôles et permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions
        $permissions = [
            'view products', 'create products', 'edit products', 'delete products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view orders', 'create orders', 'edit orders', 'delete orders',
            'view users', 'create users', 'edit users', 'delete users',
            'view reviews', 'create reviews', 'edit reviews', 'delete reviews',
            'view payments', 'create payments', 'edit payments', 'delete payments',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Créer les rôles et attribuer les permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all()); // Admin a toutes les permissions

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view products', 'create products', 'edit products',
            'view categories', 'create categories', 'edit categories',
            'view orders', 'edit orders',
            'view users', 'edit users',
            'view reviews', 'delete reviews',
            'view payments',
        ]);

        $customerRole = Role::create(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'view products',
            'view categories',
            'create orders',
            'view orders',
            'create reviews',
            'view payments',
        ]);
    }
}