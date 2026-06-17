<?php

namespace Tests\Feature\Repair;

use App\Enums\RepairStatus;
use App\Services\Repair\RepairTicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesRepairTestData;
use Tests\TestCase;

class RepairTicketTest extends TestCase
{
    use RefreshDatabase;
    use CreatesRepairTestData;

    public function test_can_create_repair_ticket(): void
    {
        $deviceModel = $this->createDeviceModel();
        $options = $this->createOptions();

        $service = app(RepairTicketService::class);

        $ticket = $service->create(
            $this->validTicketData($deviceModel, $options)
        );

        $this->assertDatabaseHas('customers', [
            'fullname' => 'yassine',
            'email' => 'yassine@fr.lo',
        ]);

        $this->assertDatabaseHas('repair_tickets', [
            'id' => $ticket->id,
            'device_model_id' => $deviceModel->id,
            'status' => RepairStatus::RECEIVED->value,
        ]);
    }

    public function test_can_selected_options_when_creating_ticket(): void
    {
        $deviceModel = $this->createDeviceModel();
        $options = $this->createOptions();

        $service = app(RepairTicketService::class);

        $ticket = $service->create(
            $this->validTicketData($deviceModel, $options)
        );

        $this->assertDatabaseHas('repair_ticket_options', [
            'repair_ticket_id' => $ticket->id,
            'spec_attribute_option_id' => $options['black']->id,
        ]);

        $this->assertDatabaseHas('repair_ticket_options', [
            'repair_ticket_id' => $ticket->id,
            'spec_attribute_option_id' => $options['eight']->id,
        ]);
    }

    public function test_can_selected_attributes_for_form(): void
    {
        $deviceModel = $this->createDeviceModel();
        $options = $this->createOptions();

        $service = app(RepairTicketService::class);

        $ticket = $service->create(
            $this->validTicketData($deviceModel, $options)
        );

        $ticket->load('selectedOptions.specAttribute');

        $result = $service->getSelectedAttributesForForm($ticket);

        $this->assertEquals([
            'Color' => $options['black']->id,
            'Ram' => $options['eight']->id,
        ], $result);
    }

    public function test_can_update_repair_ticket(): void
    {
        $deviceModel = $this->createDeviceModel();
        $options = $this->createOptions();

        $service = app(RepairTicketService::class);

        $ticket = $service->create(
            $this->validTicketData($deviceModel, $options)
        );

        $service->update([
            'fullname' => 'yassine',
            'email' => 'yassine@fr.lo',
            'phone' => '3848484',
            'final_price' => '199',
        ], $ticket);

        $this->assertDatabaseHas('repair_tickets', [
            'id' => $ticket->id,
            'final_price' => '199',
        ]);
    }

    public function test_can_update_customer_information(): void
    {
        $deviceModel = $this->createDeviceModel();
        $options = $this->createOptions();

        $service = app(RepairTicketService::class);

        $ticket = $service->create(
            $this->validTicketData($deviceModel, $options)
        );

        $service->update([
            'fullname' => 'yassine',
            'email' => 'yassine-updated@fr.it',
            'phone' => '999999',
        ], $ticket);

        $this->assertDatabaseHas('customers', [
            'id' => $ticket->customer_id,
            'fullname' => 'yassine',
            'email' => 'yassine-updated@fr.it',
            'phone' => '999999',
        ]);
    }
}
