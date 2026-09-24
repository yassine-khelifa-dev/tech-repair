<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesRepairTestData;
use Tests\TestCase;

class DeviceModelTest extends TestCase
{
    use RefreshDatabase,
        CreatesRepairTestData;


    public function test_endpoint_get_device_attributes_options_by_model_ok(): void
    {
        // create Attr & options:
        $d_attr = $this->createAttributeWithOptions(5);
        // create Model:
        $device_model = $this->createDeviceModel();
        // link device model <-> options : table: device_model_allowed_options
        $device_model->allowed_options()->sync($d_attr->specOptions);

        $response = $this->getJson("/api/device-models/" . $device_model->id . "/attributes");

        // Check response ??
        $response->assertOk();
        $response->assertJsonCount(5, 'data.0.options');
    }
}
