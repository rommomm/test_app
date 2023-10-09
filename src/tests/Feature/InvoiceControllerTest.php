<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public const ACCESS_DENIED = "Access Denied";


    public function testGetAll(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Invoice::factory()->count(5);

        $response = $this->getJson(route('invoice.index'));
        $response->assertStatus(200);

    }

    public function testStore(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'amount' => 100.0,
            'description' => 'Test invoice description'
        ];

        $response = $this->postJson(route('invoice.store'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'amount' => 100.0,
                'description' => 'Test invoice description'
            ]);
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $data = [
            'amount' => 200.0,
            'description' => 'Updated invoice description'
        ];

        $response = $this->putJson(route('invoice.update', $invoice), $data);

        $response->assertStatus(200)
            ->assertJson([
                'amount' => 200.0,
                'description' => 'Updated invoice description'
            ]);
    }

    public function testUpdateUnauthorized(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invoice = Invoice::factory()->create();

        $data = [
            'amount' => 200.0,
            'description' => 'Updated invoice description'
        ];

        $response = $this->putJson(route('invoice.update', $invoice), $data);

        $response->assertStatus(403)
            ->assertJsonFragment(['message' => self::ACCESS_DENIED]);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson(route('invoice.destroy', $invoice));

        $response->assertStatus(200);
    }

    public function testDestroyUnauthorized(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invoice = Invoice::factory()->create();

        $response = $this->deleteJson(route('invoice.destroy', $invoice));

        $response->assertStatus(403)
            ->assertJsonFragment(['message' => self::ACCESS_DENIED]);

    }
}
