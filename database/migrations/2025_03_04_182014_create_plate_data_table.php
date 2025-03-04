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
        Schema::create('plate_data', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->string('state');
            $table->string('vin')->unique();
            $table->string('fuel')->nullable();
            $table->string('make')->nullable();
            $table->string('name')->nullable();
            $table->string('trim')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('color_name')->nullable();
            $table->string('color_abbreviation', 10)->nullable();
            $table->string('model')->nullable();
            $table->string('style')->nullable();
            $table->string('engine')->nullable();
            $table->string('drive_type')->nullable();
            $table->string('transmission')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plate_data');
    }
};
