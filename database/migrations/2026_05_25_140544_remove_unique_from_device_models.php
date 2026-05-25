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
        Schema::table('device_models', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->unique(['name', 'brand_id' ]);
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_models', function (Blueprint $table) {

            $table->unique('name');

        });
    }
};
