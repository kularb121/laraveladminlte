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
            $table->string('name')->unique();
            $table->date('manu_date');
            $table->unsignedBigInteger('status'); // Change to unsignedBigInteger
            $table->text('note')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns

            //Add foreign key constraint
            $table->foreign('status')->references('id')->on('statuses')->onDelete('cascade');
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
