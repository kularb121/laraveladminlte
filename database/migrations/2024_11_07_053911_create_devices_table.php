<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Change id() to uuid()
            $table->string('number')->unique();
            $table->string('name')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->references('id'); 
            $table->string('mobile_number')->nullable();
            $table->string('manu_date')->default(date('Y-m-d'));
            $table->uuid('customer_id')->nullable()->constrained('customers'); 
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
        Schema::dropIfExists('devices');
    }
};
