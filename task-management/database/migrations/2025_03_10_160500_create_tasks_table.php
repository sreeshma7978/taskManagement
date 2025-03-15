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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); 
            $table->string('title');  // Task title (required)
            $table->string('description');  // Task description
            $table->unsignedBigInteger('assigned_to');  // Foreign key to users table (unsignedBigInteger is used for foreign keys)
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'expired', 'completed'])->default('pending');  // Status with default value 'pending'
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('due_date')->nullable();  // Timestamp for due date (nullable)
            $table->timestamps();  // Created_at and updated_at timestamps

            // Adding foreign key constraint on the 'assigned_to' column referencing 'users' table
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
