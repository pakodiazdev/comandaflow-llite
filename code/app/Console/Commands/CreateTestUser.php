<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-user {--role=employee : The role to assign to the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user with specified role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roleName = $this->option('role');
        
        // Verificar que el rol existe
        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Role '{$roleName}' does not exist. Available roles: " . Role::pluck('name')->implode(', '));
            return 1;
        }

        $name = $this->ask('User name', 'Test User');
        $email = $this->ask('Email', 'test@comadaflow.com');
        $password = $this->secret('Password (leave empty for "password")') ?: 'password';
        $phone = $this->ask('Phone (optional)', '+1234567890');
        $position = $this->ask('Position (optional)', 'Test Position');

        // Verificar si el usuario ya existe
        if (User::where('email', $email)->exists()) {
            $this->error("User with email '{$email}' already exists.");
            return 1;
        }

        // Crear el usuario
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'phone' => $phone ?: null,
            'position' => $position ?: null,
            'hire_date' => now(),
            'email_verified_at' => now(), // Pre-verificar para testing
        ]);

        // Asignar el rol
        $user->assignRole($role);

        $this->info("✅ User created successfully!");
        $this->table(['Field', 'Value'], [
            ['ID', $user->id],
            ['Name', $user->name],
            ['Email', $user->email],
            ['Role', $roleName],
            ['Phone', $user->phone ?: 'N/A'],
            ['Position', $user->position ?: 'N/A'],
            ['Hire Date', $user->hire_date?->format('Y-m-d')],
        ]);

        return 0;
    }
}
