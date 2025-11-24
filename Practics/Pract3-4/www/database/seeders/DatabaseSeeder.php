<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@autoservice.local',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'manager',
            'email' => 'manager@autoservice.local',
            'password' => Hash::make('manager123'),
            'role' => 'manager',
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@autoservice.local',
            'password' => Hash::make('user123'),
            'role' => 'client',
        ]);

        $this->call([
            ServiceSeeder::class,
        ]);
    }
}
