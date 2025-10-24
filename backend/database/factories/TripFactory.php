<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Destionation;
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
        $destination = Destination::latest()->frist();

        return [
            "departure_date" => now(),
            "return_date" => now(),
            "destionation_id" => $destination->id;
            "status_id" => Status::where('name', TripStatus::REQUESTED)->first()->id,
            "user_id" => $user->id,
        ];
    }
}
