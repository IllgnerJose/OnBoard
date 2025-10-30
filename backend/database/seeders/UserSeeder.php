<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Administrador',
            'email' => 'admin@onboard.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Usuário Padrão',
            'email' => 'user@onboard.com',
            'password' => Hash::make('password'),
        ]);

    }
}