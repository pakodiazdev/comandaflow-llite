<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuarios de demostración si no existen
        $demoUsers = [
            [
                'name' => 'Admin Demo',
                'email' => 'admin@demo.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0101',
                'position' => 'System Administrator',
                'hire_date' => now()->subMonths(12),
                'email_verified_at' => now(),
                'role' => 'admin'
            ],
            [
                'name' => 'Manager Demo',
                'email' => 'manager@demo.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0102',
                'position' => 'Restaurant Manager',
                'hire_date' => now()->subMonths(8),
                'email_verified_at' => now(),
                'role' => 'manager'
            ],
            [
                'name' => 'John Smith',
                'email' => 'john@demo.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0103',
                'position' => 'Chef',
                'hire_date' => now()->subMonths(6),
                'email_verified_at' => now(),
                'role' => 'employee'
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria@demo.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0104',
                'position' => 'Waitress',
                'hire_date' => now()->subMonths(4),
                'email_verified_at' => now(),
                'role' => 'employee'
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@demo.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0105',
                'position' => 'Host',
                'hire_date' => now()->subMonths(2),
                'email_verified_at' => now(),
                'role' => 'employee'
            ],
        ];

        foreach ($demoUsers as $userData) {
            // Solo crear si el usuario no existe
            if (!User::where('email', $userData['email'])->exists()) {
                $roleName = $userData['role'];
                unset($userData['role']);
                
                $user = User::create($userData);
                
                // Asignar rol
                $role = Role::where('name', $roleName)->first();
                if ($role) {
                    $user->assignRole($role);
                }
                
                $this->command->info("✅ Created demo user: {$user->name} ({$user->email}) with role: {$roleName}");
            } else {
                $this->command->info("⏭️  User already exists: {$userData['email']}");
            }
        }
    }
}
