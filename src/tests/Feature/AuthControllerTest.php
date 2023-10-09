<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public const INVALID_CREDENTIALS = "Credentials are invalid, please check your email or password";

    public function testSignUp(): void
    {
        $payload = [
            'name' => 'test',
            'email' => 'test@test.test',
            'password' => 'testtest'
        ];

        $response = $this->postJson(route('signUp'), $payload);
        $response->assertStatus(200);
    }

    public function testSignUpWeakPassword(): void
    {
        $payload = [
            'name' => 'test',
            'email' => 'test1@test.test',
            'password' => 'test',
        ];

        $response = $this->postJson(route('signUp'), $payload);
        $response->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
    }

    public function testSignUpExistingEmail(): void
    {
        User::factory()->create([
            'email' => 'test2@test.test'
        ]);

        $payload = [
            'name' => 'test',
            'email' => 'test2@test.test',
            'password' => 'testtest',
        ];

        $response = $this->postJson(route('signUp'), $payload);
        $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
    }

    public function testSignInWithCorrectCredentials(): void
    {
        User::factory()->create([
            'email' => 'test3@test.test',
            'password' => 'testtest'
        ]);

        $payload = [
            'email' => 'test3@test.test',
            'password' => 'testtest',
        ];

        $response = $this->json('POST', route('signIn'), $payload);
        $response->assertStatus(200);
    }

    public function testSignInWithIncorrectCredentials(): void
    {
        User::factory()->create([
            'email' => 'test4@test.test',
            'password' => 'testtest'
        ]);

        $payload = [
            'email' => 'test4@test.test',
            'password' => 'testtest1',
        ];

        $response = $this->postJson(route('signIn'), $payload);
        $response->assertStatus(401)
            ->assertJsonFragment(['message' => self::INVALID_CREDENTIALS]);
    }

    public function testSignOut(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson(route('signOut'));

        $response->assertStatus(200);
    }
}
