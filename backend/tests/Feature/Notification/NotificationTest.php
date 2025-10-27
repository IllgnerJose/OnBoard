<?php

use App\Models\User;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('returns the latest 20 notifications for the authenticated user', function () {
    Notification::factory()->count(25)->create([
        'notifiable_id' => $this->user->id,
        'notifiable_type' => User::class,
    ]);

    $response = $this->getJson('/api/notifications');

    $response->assertOk()
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'type', 'data', 'read_at', 'created_at']
            ]
        ]);

    expect($response->json('data'))->toHaveCount(20);
});

it('marks a specific notification as read', function () {
    $notification = Notification::factory()->create([
        'notifiable_id' => $this->user->id,
        'notifiable_type' => User::class,
        'read_at' => null,
    ]);

    $response = $this->putJson("/api/notifications/{$notification->id}/read");

    $response->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'Notificação marcada como lida.'
        ]);

    $notification->refresh();
    expect($notification->read_at)->not->toBeNull();
});

it('marks all unread notifications as read', function () {
    Notification::factory()->count(3)->create([
        'notifiable_id' => $this->user->id,
        'notifiable_type' => User::class,
        'read_at' => null,
    ]);

    $response = $this->putJson('/api/notifications/mark-all-read');

    $response->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'Todas as notificações marcadas como lidas.'
        ]);

    $this->assertDatabaseMissing('notifications', [
        'notifiable_id' => $this->user->id,
        'read_at' => null,
    ]);
});

it('returns the unread notifications count', function () {
    Notification::factory()->count(2)->create([
        'notifiable_id' => $this->user->id,
        'notifiable_type' => User::class,
        'read_at' => null,
    ]);

    Notification::factory()->create([
        'notifiable_id' => $this->user->id,
        'notifiable_type' => User::class,
        'read_at' => now(),
    ]);

    $response = $this->getJson('/api/notifications/unread-count');

    $response->assertOk()
        ->assertJson([
            'success' => true,
            'data' => ['count' => 2],
        ]);
});
