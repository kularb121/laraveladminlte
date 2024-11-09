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
        Schema::create('device_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->references('id');
            $table->foreignId('asset_id')->constrained('assets')->references('id');
            $table->date('state_date')->nullable()->default(now()); 
            $table->date('stop_date')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->references('id');
            $table->string('note')->nullable();
            $table->string('note2')->nullable();
            $table->string('note3')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_assets');
    }
};
