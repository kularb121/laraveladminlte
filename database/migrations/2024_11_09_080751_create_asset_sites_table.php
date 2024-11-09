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
        Schema::create('asset_sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->references('id');
            $table->foreignId('site_id')->constrained('sites')->references('id');
            $table->date('start_date')->nullable()->default(now());
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
        Schema::dropIfExists('asset_sites');
    }
};