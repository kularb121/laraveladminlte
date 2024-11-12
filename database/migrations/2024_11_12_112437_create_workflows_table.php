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
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); 
            $table->date('due_date')->nullable(); 
            $table->unsignedBigInteger('assigned_to')->nullable(); 
            $table->unsignedBigInteger('created_by')->nullable(); 
            $table->timestamps(); 
    
            //Add foreign key constraints if necessary
            $table->foreign('assigned_to')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');

            // In the `create_workflows_table` migration
            $table->json('steps')->nullable(); // Store workflow steps and connections as JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflows');
    }
};
