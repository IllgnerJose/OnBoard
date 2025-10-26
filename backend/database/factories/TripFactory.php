<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Destination;
use App\Models\Status;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $destination = Destination::factory()->create();

        return [
            "departure_date" => now(),
            "return_date" => now(),
            "destination_id" => $destination->id,
            "status_id" => Status::factory()->create()->id,
            "user_id" => $user->id,
        ];
    }

    public function canceled()
    {
        return $this->state(fn (array $attributes) => [
            "status_id" => Status::factory()->canceled()->create()->id,
        ]);
    }

    public function approved()
    {
        return $this->state(fn (array $attributes) => [
            "status_id" => Status::factory()->approved()->create()->id,
        ]);
    }
}
