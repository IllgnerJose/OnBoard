<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\NotNotifications\GenericNotification;
use App\Models\User;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'type' => GenericNotification::class,
            'notifiable_type' => User::class,
            'notifiable_id' => null, 
            'data' => json_encode([
                'title' => fake()->sentence(),
                'message' => fake()->paragraph(),
                'action_url' => fake()->optional()->url(),
            ]),
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function read()
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => now(),
        ]);
    }

    public function unread()
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => null,
        ]);
    }

    public function old(int $days = 7)
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => now()->subDays($days),
            'updated_at' => now()->subDays($days),
        ]);
    }

    public function type(string $type)
    {
        return $this->state(fn (array $attributes) => [
            'type' => $type,
        ]);
    }

    public function withData(array $data)
    {
        return $this->state(fn (array $attributes) => [
            'data' => array_merge($attributes['data'], $data),
        ]);
    }
}