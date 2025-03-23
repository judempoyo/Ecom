<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Créer un admin
        $admin = User::create([
            'name' => 'Jude',
            'email' => 'mpoyojude0@gmail.com',
            'password' => Hash::make('12345678'),
            'profile_photo' => 'users/admin.jpg',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Créer un manager
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('12345678'),
            'profile_photo' => 'users/manager.jpg',
            'is_active' => true,
        ]);
        $manager->assignRole('manager');

        // Créer un client
        $customer = User::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('12345678'),
            'profile_photo' => 'users/customer.jpg',
            'is_active' => true,
        ]);
        $customer->assignRole('customer');

        // Créer 10 utilisateurs fictifs avec le rôle 'customer'
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('customer');
        });
    }
}