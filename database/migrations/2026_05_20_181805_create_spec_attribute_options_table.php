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
        Schema::create('spec_attribute_options', function (Blueprint $table) {
           $table->id();
            $table->foreignId('spec_attribute_id')->constrained()->cascadeOnDelete();

            $table->string('value', 255);
            $table->string('label', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->unique(['spec_attribute_id', 'value'], 'spec_attr_option_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spec_attribute_options');
    }
};
