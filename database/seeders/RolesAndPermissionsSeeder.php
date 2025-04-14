<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for users
        $userPermissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        // Create permissions for savings accounts
        $savingsAccountPermissions = [
            'view any savings account',
            'view own savings account',
            'create savings account',
            'edit any savings account',
            'edit own savings account',
            'delete any savings account',
            'delete own savings account',
        ];

        // Create permissions for savings goals
        $savingsGoalPermissions = [
            'view any savings goal',
            'view own savings goal',
            'create savings goal',
            'edit any savings goal',
            'edit own savings goal',
            'delete any savings goal',
            'delete own savings goal',
        ];

        // Create permissions for transactions
        $transactionPermissions = [
            'view any transaction',
            'view own transaction',
            'create transaction',
            'edit any transaction',
            'edit own transaction',
            'delete any transaction',
            'delete own transaction',
            'approve transaction',
        ];

        // Create permissions for payment methods
        $paymentMethodPermissions = [
            'view payment methods',
            'create payment method',
            'edit payment method',
            'delete payment method',
        ];

        // Create permissions for audit logs
        $auditLogPermissions = [
            'view audit logs',
            'delete audit logs',
        ];

        // Create dashboard permissions
        $dashboardPermissions = [
            'view any dashboard stats',
            'view own dashboard stats',
        ];

        // Create system permissions
        $systemPermissions = [
            'access admin panel',
            'manage settings',
            'generate reports',
        ];

        // Combine all permissions
        $allPermissions = array_merge(
            $userPermissions,
            $savingsAccountPermissions,
            $savingsGoalPermissions,
            $transactionPermissions,
            $paymentMethodPermissions,
            $auditLogPermissions,
            $dashboardPermissions,
            $systemPermissions
        );

        // Create permissions in database
        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin role
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin role
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'view any savings account',
            'edit any savings account',
            'view any savings goal',
            'edit any savings goal',
            'view any transaction',
            'edit any transaction',
            'approve transaction',
            'view payment methods',
            'create payment method',
            'edit payment method',
            'view audit logs',
            'view any dashboard stats',
            'access admin panel',
            'generate reports',
        ]);

        // Manager role
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view users',
            'view any savings account',
            'view any savings goal',
            'view any transaction',
            'approve transaction',
            'view payment methods',
            'view audit logs',
            'view any dashboard stats',
            'generate reports',
        ]);

        // Regular User role
        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo([
            'view own savings account',
            'create savings account',
            'edit own savings account',
            'view own savings goal',
            'create savings goal',
            'edit own savings goal',
            'delete own savings goal',
            'view own transaction',
            'create transaction',
            'view payment methods',
            'view own dashboard stats',
        ]);
    }
}
