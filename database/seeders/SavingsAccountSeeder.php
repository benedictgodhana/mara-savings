<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SavingsAccount;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SavingsAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find the admin user by their role using Spatie's role functionality
        $adminRole = Role::findByName('admin');  // You can replace 'admin' with the name of your admin role

        // Find the user with the 'admin' role
        $adminUser = User::role('admin')->first(); // Or you can use $adminRole->users() if you have multiple admin users

        // Create a savings account for the admin user
        if ($adminUser) {
            SavingsAccount::create([
                'user_id' => $adminUser->id,
                'account_number' => 'ACC123456789',  // You can generate this dynamically or statically
                'balance' => 1000.00,  // Initial balance
                'status' => 'active',  // Ensure this matches the enum options (active, inactive, frozen)
                'type' => 'basic',  // Ensure this matches the enum options (basic, goal_based, fixed_term)
                'interest_rate' => 5.0,  // Example interest rate
            ]);
        } else {
            echo "No admin user found.";
        }
    }
}
