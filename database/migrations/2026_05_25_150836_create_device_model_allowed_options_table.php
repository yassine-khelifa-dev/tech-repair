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
        Schema::create('device_model_allowed_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_model_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spec_attribute_option_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unique(['device_model_id', 'spec_attribute_option_id'], 'device_model_allowed_option_unq');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_model_configurations');
    }
};
