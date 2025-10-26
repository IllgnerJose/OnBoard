<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\UserRole;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => UserRole::USER->name,
        ];
    }

    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            "name" => UserRole::ADMIN->name,
        ]);
    }
}
