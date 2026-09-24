<?php

namespace Tests\Feature\Api;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_endpoint_get_brands_ok(): void
    {
        Brand::factory(10)->create();
        $response = $this->getJson('/api/brands');
        $response->assertOk();
        $response->assertJsonCount(10, 'data');
    }
}
