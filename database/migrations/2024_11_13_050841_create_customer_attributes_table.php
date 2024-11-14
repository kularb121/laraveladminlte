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
        Schema::create('customer_attributes', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('customer_id')->nullable()->constrained('customers')->onDelete('cascade');
            $table->string('name');
            $table->string('unit')->nullable();
            $table->string('display_type')->default('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_attributes');
    }
};
