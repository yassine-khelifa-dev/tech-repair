<?php

namespace Tests\Feature\Api;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesRepairTestData;
use Tests\TestCase;

class SpecAttributeTest extends TestCase
{
    use RefreshDatabase, CreatesRepairTestData;
    /**
     * A basic feature test example.
     */
    public function test_endpoint_get_device_attributes_ok(): void
    {
        $this->createAttributeWithOptions(5);
        $response = $this->getJson('/api/device-attributes');
        $response->assertOk();
        $response->assertJsonCount(5, 'data.0.options');
    }
}
