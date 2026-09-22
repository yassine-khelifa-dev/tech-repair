<?php

namespace Tests\Feature\Repair;

use App\Enums\RepairStatus;
use App\Jobs\SendRepairLogNotificationJob;
use App\Notifications\RepairLogCreatedNotification;
use App\Services\Repair\RepairLogService;
use App\Services\Repair\RepairTicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\PHP\Job;
use Tests\CreatesRepairTestData;
use Tests\TestCase;

class RepairLogTest extends TestCase
{
    use RefreshDatabase;
    use CreatesRepairTestData;
    /**
     * A basic feature test example.
     *  'repair_ticket_id',
     */
    private function ticketRepairData()
    {
        $deviceModel = $this->createDeviceModel();
        $options = $this->createOptions();

        return app(RepairTicketService::class)->create(
            $this->validTicketData($deviceModel, $options)
        );
    }


    public function test_can_add_log(): void
    {
        $user = $this->createUser();
        $deviceModel = $this->createDeviceModel();
        $options = $this->createOptions();

        $serviceTicket = app(RepairTicketService::class);

        $ticket = $serviceTicket->create(
            $this->validTicketData($deviceModel, $options)
        );

        app(RepairLogService::class)->addLog(
            [
                'user_id' => $user->id,
                'old_status' => $ticket->status,
                'new_status' => RepairStatus::WAITING_PARTS->value,
                'is_visible_to_customer' => 1,
                'message' => 'Velit et dolore cillum amet.',
                'images_log' => []
            ],
            $ticket
        );

        $this->assertDatabaseHas('repair_logs', [
            'new_status' => RepairStatus::WAITING_PARTS->value,
            'is_visible_to_customer' => 1,
            'repair_ticket_id' => $ticket->id
        ]);

        $log = $ticket->logs()->latest()->first();

        $this->assertEquals(
            $log->new_status,
            $ticket->fresh()->status
        );
    }

    public function test_can_add_log_with_uploaded_images(): void
    {
        Storage::fake('public');

        $user = $this->createUser();
        $deviceModel = $this->createDeviceModel();
        $options = $this->createOptions();

        $ticket = app(RepairTicketService::class)->create(
            $this->validTicketData($deviceModel, $options)
        );

        app(RepairLogService::class)->addLog([
            'user_id' => $user->id,
            'new_status' => RepairStatus::WAITING_PARTS->value,
            'is_visible_to_customer' => true,
            'message' => 'Customer device inspected.',
            'images_log' => [UploadedFile::fake()->image('device-photo.jpg')],
        ], $ticket);

        $log = $ticket->logs()->latest()->first();

        $this->assertDatabaseHas('repair_log_images', [
            'repair_log_id' => $log->id,
        ]);

        $path = $log->images()->first()->path;

        Storage::disk('public')->assertExists($path);
    }

    public function test_notification_job_is_dispatched_when_log_is_visible_to_customer()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $repair_ticket = $this->ticketRepairData();
        Queue::fake();

        $response = $this->post(route('repair-ticket-logs', $repair_ticket), [
            'user_id' => $user->id,
            'old_status' => $repair_ticket->status,
            'new_status' => RepairStatus::WAITING_PARTS->value,
            'is_visible_to_customer' => 1,
            'message' => 'Velit et dolore cillum amet.',
            'images_log' => []
        ]);

        $response->assertRedirect();

        Queue::assertPushed(SendRepairLogNotificationJob::class);
    }



    public function test_notification_job_is_not_dispatched_when_log_is_not_visible_to_customer()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $repair_ticket = $this->ticketRepairData();
        Queue::fake();

        $response = $this->post(route('repair-ticket-logs', $repair_ticket), [
            'user_id' => $user->id,
            'old_status' => $repair_ticket->status,
            'new_status' => RepairStatus::WAITING_PARTS->value,
            'is_visible_to_customer' => 0,
            'message' => 'Velit et dolore cillum amet.',
            'images_log' => []
        ]);

        $response->assertRedirect();

        Queue::assertNothingPushed();
    }
}
