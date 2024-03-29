<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetTheirProfile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1/profile');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonCount(2)
            ->assertJsonFragment(['name' => $user->name]);
    }

    public function testUnauthenticatedUserCannotAccessProfile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user);
        Auth::logout();
        $response = $this->getJson('/api/v1/profile');
        $this->assertGuest();

        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }


    public function testUserCanUpdateNameAndEmail()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patchJson('/api/v1/profile', [
            'name' => 'John Updated',
            'email' => 'john_updated@example.com',
        ]);

        $response
            ->assertStatus(202)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonCount(2)
            ->assertJsonFragment(['name' => 'John Updated']);

        $this->assertDatabaseHas('users', [
            'name' => 'John Updated',
            'email' => 'john_updated@example.com',
        ]);
    }

    public function testUserCannotUpdateNameAndEmailWithNonMatchingPassword()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'testing123',
            'password_confirmation' => 'incorrectpassword',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The password field confirmation does not match.',
            ]);
    }

    public function testUserCanChangePassword()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password'      => 'password',
            'password'              => 'testing123',
            'password_confirmation' => 'testing123',
        ]);

        $response->assertStatus(202);
    }

    public function testUserCannotUpdatePasswordWithNonMatchingPassword()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'testing123',
            'password_confirmation' => 'incorrectpassword',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The password field confirmation does not match.',
            ]);
    }
}
