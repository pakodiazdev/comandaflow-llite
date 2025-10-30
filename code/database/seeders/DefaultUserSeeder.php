<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@comandaflow.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'position' => 'System Administrator',
            'hire_date' => now(),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create Manager User
        $manager = User::create([
            'name' => 'Restaurant Manager',
            'email' => 'manager@comandaflow.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567891',
            'position' => 'Restaurant Manager',
            'hire_date' => now(),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('manager');

        // Create Waiter User
        $waiter = User::create([
            'name' => 'Waiter Demo',
            'email' => 'waiter@comandaflow.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567892',
            'position' => 'Waiter',
            'hire_date' => now(),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $waiter->assignRole('waiter');

        // Create Kitchen User
        $kitchen = User::create([
            'name' => 'Kitchen Staff',
            'email' => 'kitchen@comandaflow.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567893',
            'position' => 'Kitchen Staff',
            'hire_date' => now(),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $kitchen->assignRole('kitchen');
    }
}
