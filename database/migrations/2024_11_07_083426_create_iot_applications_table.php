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
            $table->uuid('device_id')->constrained('devices'); 
            $table->uuid('asset_id')->constrained('assets');
            $table->date('start_date');
            $table->date('stop_date');
            $table->unsignedBigInteger('status'); 
            $table->string('note')->nullable();
            $table->timestamps();
    

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

