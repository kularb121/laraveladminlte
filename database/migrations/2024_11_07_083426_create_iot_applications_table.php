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
        Schema::create('iot_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('asset_id');
            $table->date('start_date');
            $table->date('stop_date');
            $table->unsignedBigInteger('status'); 
            $table->string('note')->nullable();
            $table->timestamps();
    
            $table->foreign('device_id')->references('id')->on('devices');
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->foreign('status')->references('id')->on('statuses'); 
            $table->unique(['device_id', 'asset_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iot_applications');
    }
};

