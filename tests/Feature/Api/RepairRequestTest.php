<?php

namespace Tests\Feature\Api;

use App\Models\RepairRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\CreatesRepairTestData;
use Tests\TestCase;

class RepairRequestTest extends TestCase
{

    use RefreshDatabase, CreatesRepairTestData;

    public function test_create_repair_request_with_valid_data(): void
    {
        $device_model = $this->createDeviceModel();
        $data = $this->validTicketDataForApi($device_model, $this->createOptions());
        $response = $this->postJson('api/repair-request/create', $data);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['id', 'status'],
        ]);
        $response->assertJsonPath('data.status', 'pending');
        $this->assertDatabaseCount('repair_requests', 1);
    }

    public function test_create_repair_request_with_missing_data(): void
    {
        $device_model = $this->createDeviceModel();
        $data = $this->badTicketDataForApi_without_email_options($device_model, $this->createOptions());
        $response = $this->postJson('api/repair-request/create', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('email');
        $response->assertJsonValidationErrorFor('option_ids');
    }


    public function test_create_repair_request_with_wrong_options(): void
    {
        $device_model = $this->createDeviceModel();

        $data = $this->validTicketDataForApi_with_wrong_options($device_model);
        $response = $this->postJson('api/repair-request/create', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('option_ids');
    }


    public function test_create_repair_request_with_file(): void
    {
        Storage::fake('public');

        $device_model = $this->createDeviceModel();
        $data = $this->validTicketDataForApi_with_file($device_model, $this->createOptions());
        $response = $this->post('api/repair-request/create', $data);
        $response->assertCreated();


        $repairRequest = RepairRequest::latest()->first();
        $path = $repairRequest->data['images_device_path'][0]['path'];

        $this->assertTrue(
            Storage::disk('public')->exists($path)
        );
    }
}


/**
 *
 *
 *  Notification::assertSentOnDemand(
            RepairRequestReceivedNotification::class,
            function (
                RepairRequestReceivedNotification $notification,
                array $channels,
                object $notifiable
            ) {
                return $channels === ['mail']
                    && $notifiable->routes['mail'] === 'tech-repair-admin@eprostam.com';
            }
        );

        Notification::assertSentTo(
            $admin,
            RepairRequestReceivedNotification::class,
            fn (
                RepairRequestReceivedNotification $notification,
                array $channels
            ) => $channels === ['database']
        );
 */
