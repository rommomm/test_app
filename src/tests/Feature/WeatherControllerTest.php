<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetCurrentWeather(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson(route('getWeather'));

        $response->assertStatus(200)
            ->assertJson([
                'user' => true,
                'main' => true
            ]);
    }

    public function testGetCurrentWeatherUnauthenticated(): void
    {
        $response = $this->getJson(route('getWeather'));

        $response->assertStatus(401);
    }
}
