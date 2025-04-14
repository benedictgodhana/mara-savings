<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Assign admin role
        $admin->assignRole('admin');

        // Create a manager user
        $manager = User::create([
            'name' => 'Manager User',
            'username' => 'manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);

        // Assign manager role
        $manager->assignRole('manager');

        // Create a regular user
        $user = User::create([
            'name' => 'Regular User',
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        // Assign user role
        $user->assignRole('user');

        // Optionally create a super admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Assign super-admin role
        $superAdmin->assignRole('super-admin');
    }
}
