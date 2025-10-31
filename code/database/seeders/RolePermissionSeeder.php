<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'users.create',
            'users.read', 
            'users.update',
            'users.delete',
            'users.assign-roles',
            
            // Supplier management
            'suppliers.create',
            'suppliers.read',
            'suppliers.update',
            'suppliers.delete',
            
            // Product management
            'products.create',
            'products.read',
            'products.update',
            'products.delete',
            
            // Order management
            'orders.create',
            'orders.read',
            'orders.update', 
            'orders.delete',
            'orders.process',
            
            // Menu management
            'menu.create',
            'menu.read',
            'menu.update',
            'menu.delete',
            
            // Reports
            'reports.view',
            'reports.export',
            
            // Settings
            'settings.manage',
            
            // Dashboard
            'dashboard.access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Admin - Full access
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        // Manager - Restaurant management
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->syncPermissions([
            'users.read', 'users.update', 'users.assign-roles',
            'suppliers.create', 'suppliers.read', 'suppliers.update', 'suppliers.delete',
            'products.create', 'products.read', 'products.update', 'products.delete',
            'orders.create', 'orders.read', 'orders.update', 'orders.process',
            'menu.create', 'menu.read', 'menu.update', 'menu.delete',
            'reports.view', 'reports.export',
            'dashboard.access',
        ]);

        // Waiter - Customer service and orders
        $waiter = Role::firstOrCreate(['name' => 'waiter']);
        $waiter->syncPermissions([
            'suppliers.read',
            'products.read',
            'orders.create', 'orders.read', 'orders.update',
            'menu.read',
            'dashboard.access',
        ]);

        // Kitchen - Order preparation
        $kitchen = Role::firstOrCreate(['name' => 'kitchen']);
        $kitchen->syncPermissions([
            'products.read',
            'orders.read', 'orders.update',
            'menu.read',
            'dashboard.access',
        ]);
    }
}
