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
            $table->uuid('device_id')->constrained('devices'); 
            $table->uuid('asset_id')->constrained('assets');
            $table->date('start_date')->nullable()->default(now()); 
            $table->date('stop_date')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->references('id');
            $table->string('note')->nullable();
            $table->string('note2')->nullable();
            $table->string('note3')->nullable();
            $table->timestamps();
            $table->unique(['device_id', 'asset_id']);
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
