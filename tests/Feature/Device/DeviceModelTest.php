<?php

namespace Tests\Feature\Device;

use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_create_device_model_with_type_and_brand(): void
    {
        $brand = Brand::create([
            'name' => 'Seven Tech',
            'slug' => 'seven-tech'
        ]);
         $type = DeviceType::create([
            'name' => 'Smartphone',
            'slug' => 'smartphone'
        ]);

        $device_model = DeviceModel::create([
            'name' => 'iPhine 17 Pro Max',
            'slug' => 'iphone-17-pro-max',
            'brand_id' => $brand->id,
            'device_type_id' => $type->id,
        ]);

        $this->assertInstanceOf(DeviceModel::class, $device_model);

        $this->assertDatabaseHas('device_models', [
            'slug' => 'iphone-17-pro-max',
        ]);

    }
}
