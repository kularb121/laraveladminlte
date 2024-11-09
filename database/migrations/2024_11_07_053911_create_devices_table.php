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
    //     Schema::create('devices', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name')->unique();
    //         $table->date('manu_date');
    //         $table->integer('status');
    //         $table->text('note')->nullable();
    //         $table->timestamps(); // Adds created_at and updated_at columns

    //    });

    Schema::create('devices', function (Blueprint $table) {
        $table->id();
        $table->string('number')->unique();
        $table->string('name')->nullable();
        $table->foreignId('status_id')->nullable()->constrained('statuses')->references('id'); 
        $table->string('mobile_number');
        $table->string('manu_date')->default(date('Y-m-d'));
        $table->foreignId('customer_id')->nullable()->constrained('customers')->references('id'); 
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
