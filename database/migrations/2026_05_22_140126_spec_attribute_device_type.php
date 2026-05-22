<?php

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
        Schema::create('spec_attribute_device_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spec_attribute_id')->constrained()->cascadeOnDelete();
            $table->foreignId('device_type_id')->constrained()->cascadeOnDelete();

            $table->boolean('is_required')->default(false);

            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spec_attribute_device_type', function (Blueprint $table) {

            Schema::dropIfExists('spec_attribute_device_type');

        });
    }
};
