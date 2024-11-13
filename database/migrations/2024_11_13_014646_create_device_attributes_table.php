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
            $table->unsignedBigInteger('device_id');
            $table->string('name'); // Attribute name (e.g., 'temperature', 'pressure')
            $table->string('unit')->nullable(); // Unit of measurement (e.g., '°C', 'bar')
            $table->string('display_type')->default('value'); // How to display (e.g., 'value', 'chart')
            $table->timestamps();
    
            $table->foreign('device_id')->references('id')->on('devices');
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
