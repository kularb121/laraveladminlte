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
        Schema::create('sites', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Change id() to uuid()
            $table->string('number')->nullable();
            $table->string('name')->unique();
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
        Schema::dropIfExists('sites');
    }
};
