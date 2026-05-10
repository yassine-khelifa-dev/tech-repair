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
        Schema::create('device_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->string('code', 256);
            $table->string('input_type', 77);
            $table->boolean('is_filterable')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(false);


            $table->foreignId('device_type_id')->constrained('device_types')->cascadeOnDelete();

            $table->unique(['code', 'device_type_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_attributes');
    }
};
