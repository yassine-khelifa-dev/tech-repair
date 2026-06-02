<?php

use App\Enums\RepairStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repair_tickets', function (Blueprint $table) {
            $table->id();

            $table->string('ticket_number', 50)->unique();
            $table->string('device_access_info', 100)->nullable();

            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->foreignId('device_model_id')->constrained()->restrictOnDelete();

            $table->string('imei', 30)->nullable();
            $table->string('sn', 30)->nullable();
            $table->string('status', 30)->default(RepairStatus::RECEIVED->value);

            $table->text('issue_description');
            $table->text('technician_note')->nullable();

            $table->decimal('estimated_price', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();

            $table->dateTime('received_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('delivered_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_tickets');
    }
};
