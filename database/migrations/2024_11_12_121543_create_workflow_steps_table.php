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
        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workflow_id');
            $table->string('name');
            $table->text('description')->nullable(); 
    
            $table->integer('order')->default(0); // To define the order of steps
            $table->uuid('assigned_to')->constrained('users');  // User assigned to this step
            $table->string('status')->default('pending'); // Step status
            $table->timestamps();
            $table->foreign('workflow_id')->references('id')->on('workflows')->onDelete('cascade');
            // Add foreign key constraint for assigned_to if needed
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_steps');
    }
};
