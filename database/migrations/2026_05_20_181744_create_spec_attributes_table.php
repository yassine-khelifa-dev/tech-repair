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
        Schema::create('spec_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->string('code', 120);
            $table->enum('input_type',[
                            "text",
                            "textarea",
                            "number",
                            "select",
                            "multiselect",
                            "boolean"
                        ]
            )->default('text');
            $table->string('unit', 20);
            $table->boolean('is_filterable')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spec_attributes');
    }
};
