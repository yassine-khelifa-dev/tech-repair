<?php

namespace Tests\Feature\Api;

use App\Models\DeviceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceTypeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_endpoint_get_device_type_ok(): void
    {
        DeviceType::factory(10)->create();
        $response = $this->getJson('/api/device-types');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }
}
