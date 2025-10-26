<?php

namespace Database\Factories;
use App\Enums\TripStatus;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => TripStatus::REQUESTED->name,
        ];
    }

    public function approved()
    {
        return $this->state(fn (array $attributes) => [
            "name" => TripStatus::APPROVED->name,
        ]);
    }

    public function canceled()
    {
        return $this->state(fn (array $attributes) => [
            "name" => TripStatus::CANCELED->name,
        ]);
    }
}
