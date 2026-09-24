<?php

namespace Tests\Feature\Repair;

use App\Enums\RepairRequestStatus;
use App\Enums\RepairStatus;
use App\Models\RepairTicket;
use App\Notifications\RepairRequestReceivedNotification;
use App\Notifications\RepairRequestReviewedNotification;
use App\Services\Repair\RepairRequestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\CreatesRepairTestData;
use Tests\TestCase;

class RepairRequestTest extends TestCase
{
    use RefreshDatabase;
    use CreatesRepairTestData;
    /**
     * A basic feature test example.
     */

    private function dataRepairRequest()
    {
        $options = $this->createOptions();
        return [
            'fullname'          => "KHELIFA",
            'email'             => "KHELIFA@test.it",
            'phone'             => "847487648",
            'device_model_id'   => $this->createDeviceModel()->id,
            'issue_description' => "Aliqua veniam proident sint aute nulla culpa Lorem dolor.",
            'option_ids'        =>  [$options['black']->id, $options['eight']->id],
            'images_device' => []
        ];
    }



    public function test_can_create_repair_request_via_service(): void
    {
        $request = app(RepairRequestService::class)
            ->create(
                $this->dataRepairRequest()
            );

        $this->assertDatabaseHas('repair_requests', [
            'status' => RepairRequestStatus::pending->value,
            'converted_ticket_id' => null,
            'id' =>  $request->id
        ]);
    }

    public function test_can_approve_repair_request(): void
    {
        try {
            $user = $this->createUser();
            $this->actingAs($user);

            $repair_request = app(RepairRequestService::class)
                ->create($this->dataRepairRequest());

            $response = $this->post(
                route('repair-requests.review', $repair_request),
                [
                    'response' => 'Request approved.',
                    'status' => RepairRequestStatus::approved->value,
                ]
            );

            $response->assertRedirect();
            $response->assertSessionHasNoErrors();

            $this->assertDatabaseHas('repair_requests', [
                'id' => $repair_request->id,
                'status' => RepairRequestStatus::approved->value,
            ]);

            $this->assertDatabaseHas('repair_tickets', [
                'status' => RepairStatus::WAITING_DEVICE->value,
                'technician_note' => 'Request approved.',
            ]);
        } catch (\Throwable $e) {
            dump($e->getMessage());
            dump($e->getTraceAsString());

            throw $e; // Re-throw so the test still fails
        }
    }



    public function test_approved_request_cannot_be_approved_again(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $repair_request = app(RepairRequestService::class)
            ->create($this->dataRepairRequest());

        // First approval
        $this->post(route('repair-requests.review', $repair_request), [
            'response' => 'First approval message.',
            'status' => RepairRequestStatus::approved->value,
        ])->assertRedirect();

        $repair_request->refresh();

        $firstStatus = $repair_request->status;
        $firstResponse = $repair_request->response;
        $firstTicketId = $repair_request->converted_ticket_id;

        $this->assertNotNull($firstTicketId);

        // Second approval attempt
        $this->post(route('repair-requests.review', $repair_request), [
            'response' => 'Second approval message.',
            'status' => RepairRequestStatus::rejected->value,
        ])->assertRedirect();

        $repair_request->refresh();

        $this->assertSame($firstStatus, $repair_request->status);
        $this->assertSame($firstResponse, $repair_request->response);
        $this->assertSame($firstTicketId, $repair_request->converted_ticket_id);

        $this->assertDatabaseCount('repair_tickets', 1);
    }


    public function test_can_rejected()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $repair_request = app(RepairRequestService::class)
            ->create($this->dataRepairRequest());

        $response = $this->post(
            route('repair-requests.review', $repair_request),
            [
                'response' => 'Request rejected.',
                'status' => RepairRequestStatus::rejected->value,
            ]
        );
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('repair_requests', [
            'id' => $repair_request->id,
            'status' => RepairRequestStatus::rejected->value,
        ]);

        $this->assertDatabaseCount('repair_tickets', 0);
    }


    public function test_rejected_request_cannot_be_rejected_again(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $repair_request = app(RepairRequestService::class)
            ->create($this->dataRepairRequest());

        // First approval
        $this->post(route('repair-requests.review', $repair_request), [
            'response' => 'First rejected message.',
            'status' => RepairRequestStatus::rejected->value,
        ])->assertRedirect();

        $repair_request->refresh();

        $firstStatus = $repair_request->status;
        $firstResponse = $repair_request->response;
        $firstTicketId = $repair_request->converted_ticket_id;

        $this->assertNull($firstTicketId);

        // Second approval attempt
        $this->post(route('repair-requests.review', $repair_request), [
            'response' => 'Second rejected message.',
            'status' => RepairRequestStatus::approved->value,
        ])->assertRedirect();

        $repair_request->refresh();

        $this->assertSame($firstStatus, $repair_request->status);
        $this->assertSame($firstResponse, $repair_request->response);
        $this->assertSame($firstTicketId, $repair_request->converted_ticket_id);

        $this->assertDatabaseCount('repair_tickets', 0);
    }


    public function test_can_customer_receives_notification_after_review_rejected(): void
    {
        Notification::fake();

        $user = $this->createUser();
        $this->actingAs($user);

        $repair_request = app(RepairRequestService::class)
            ->create($this->dataRepairRequest());

        $this->post(
            route('repair-requests.review', $repair_request),
            [
                'response' => 'Request rejected.',
                'status' => RepairRequestStatus::rejected->value,
            ]
        )->assertRedirect();

        Notification::assertSentOnDemand(
            RepairRequestReviewedNotification::class
        );
    }

    public function test_can_customer_receives_notification_after_review_approval(): void
    {
        Notification::fake();

        $user = $this->createUser();
        $this->actingAs($user);

        $repair_request = app(RepairRequestService::class)
            ->create($this->dataRepairRequest());

        $this->post(
            route('repair-requests.review', $repair_request),
            [
                'response' => 'Request approved.',
                'status' => RepairRequestStatus::approved->value,
            ]
        )->assertRedirect();

        Notification::assertSentOnDemand(
            RepairRequestReviewedNotification::class
        );
    }
}
