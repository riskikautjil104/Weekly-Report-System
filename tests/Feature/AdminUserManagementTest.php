<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('filters admin users by search role and status', function () {
    $admin = User::factory()->create([
        'name' => 'Admin One',
        'email' => 'admin@example.test',
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    User::factory()->create([
        'name' => 'Alice Active',
        'email' => 'alice@example.test',
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    User::factory()->create([
        'name' => 'Bob Pending',
        'email' => 'bob@example.test',
        'role' => 'user',
        'email_verified_at' => null,
    ]);

    User::factory()->create([
        'name' => 'Charlie Active',
        'email' => 'charlie@example.test',
        'role' => 'user',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get(route('admin.users.index', [
            'search' => 'Bob',
            'role' => 'user',
            'status' => 'pending',
        ]))
        ->assertOk()
        ->assertSee('Bob Pending')
        ->assertSee('Pending')
        ->assertDontSee('Alice Active')
        ->assertDontSee('Charlie Active');
});
