<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Maak een specifieke admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'), // Kies een veilig wachtwoord
            'is_admin' => 1, // Admin
        ]);

        // Maak een specifieke testuser (gewone gebruiker)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_admin' => 0,
        ]);

        // Maak nog 8 willekeurige gewone users
        User::factory()->count(8)->create([
            'is_admin' => 0,
        ]);
    }
}