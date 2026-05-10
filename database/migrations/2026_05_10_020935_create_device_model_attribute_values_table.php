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
        Schema::create('device_model_attribute_values', function (Blueprint $table) {
            $table->id();

            $table->foreignId('device_attribute_id')->constrained('device_attributes')->cascadeOnDelete();
            $table->foreignId('device_model_id')->constrained('device_models')->cascadeOnDelete();
            $table->string('value', 256);



            $table->unique(
                ['device_model_id', 'device_attribute_id', 'value'],
                'dmav_model_attr_value_unique'
            );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_model_attribute_values');
    }
};
