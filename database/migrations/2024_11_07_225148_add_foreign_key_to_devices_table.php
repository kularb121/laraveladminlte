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
        Schema::table('devices', function (Blueprint $table) {
            // Change the status column to unsignedBigInteger
            // $table->unsignedBigInteger('status')->change();

            // // Add foreign key constraint
            // $table->foreign('status')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['status']);

            // Change the status column back to integer
            $table->integer('status')->change();
        });
    }
};