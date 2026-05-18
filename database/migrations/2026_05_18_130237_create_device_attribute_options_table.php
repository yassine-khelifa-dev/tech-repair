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
        Schema::create('device_attribute_options', function (Blueprint $table) {
            $table->id();
            $table->string('value', 255);
            $table->foreignId('device_attribute_id')->constrained()->cascadeOnDelete();
            $table->integer('sort_order')->default(0);

            $table->unique(['device_attribute_id', 'value'], 'dao_unique');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_attribute_options');
    }
};
