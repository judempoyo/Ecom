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
    public function run()
{
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Permissions pour les articles
    $postPermissions = [
        'create-post',
        'edit-post',
        'delete-post',
        'publish-post',
        'unpublish-post'
    ];

    // Permissions pour les commentaires
    $commentPermissions = [
        'create-comment',
        'edit-comment',
        'delete-comment'
    ];

    // Création de toutes les permissions
    foreach (array_merge($postPermissions, $commentPermissions) as $permission) {
        Permission::create(['name' => $permission]);
    }

    // Rôle Admin - Accès complet
    $admin = Role::create(['name' => 'admin']);
    $admin->givePermissionTo(array_merge($postPermissions, $commentPermissions));

    // Rôle Éditeur - Gestion des articles mais pas de suppression
    $editor = Role::create(['name' => 'editor']);
    $editor->givePermissionTo([
        'create-post',
        'edit-post',
        'publish-post',
        'unpublish-post'
    ]);

    // Rôle User - Interactions basiques
    $user = Role::create(['name' => 'user']);
    $user->givePermissionTo($commentPermissions);
}
}
