<?php

namespace Tests\Feature;

use App\Models\Zone;
use Database\Factories\ZoneFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ZoneTest extends TestCase
{
    use RefreshDatabase;

    public function testPublicUserCanGetAllZones()
    {
        Zone::factory()->create([
            'id' => 1,
            'name' => 'Green Zone',
            'price_per_hour' => 100,
        ]);

        ZoneFactory::factoryForModel(Zone::class)->count(10)->create();

        $response = $this->getJson('/api/v1/zones');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(1, 'data') // I use pagination 1 zone per page
            ->assertJsonStructure([
                'data' => [
                    [
                        '*' => 'ID', 'Zone name', 'Price per hour'
                    ],
                ]])
            ->assertJsonPath('data.0.ID', 1)
            ->assertJsonPath('data.0.Zone name', 'Green Zone')
            ->assertJsonPath('data.0.Price per hour', 100);

        $this->assertEquals(11, $response->json('meta.total'));
        $this->assertEquals(1, $response->json('meta.current_page'));
        $this->assertEquals(1, $response->json('meta.per_page'));
        $this->assertEquals(11, $response->json('meta.last_page'));
    }
}
