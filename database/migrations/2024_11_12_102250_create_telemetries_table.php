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
        Schema::create('telemetries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->timestamp('timestamp');
            $table->string('key');
            $table->string('value');

            $table->foreign('device_id')->references('id')->on('devices');
        });

        // Partitioning statement moved inside the up() method
        // DB::statement("
        //     ALTER TABLE telemetries
        //     PARTITION BY RANGE (device_id) (
        //         PARTITION p0 VALUES LESS THAN (100),
        //         PARTITION p1 VALUES LESS THAN (200),
        //         PARTITION p2 VALUES LESS THAN MAXVALUE
        //     )
        // ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telemetries');
    }
};