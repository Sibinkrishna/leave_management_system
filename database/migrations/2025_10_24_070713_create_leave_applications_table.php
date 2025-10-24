<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->id();

            // Employee who applies (foreign key to users table)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Leave type (foreign key to leave_types table)
            $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('restrict');

            // Leave duration
            $table->date('start_date');
            $table->date('end_date');

            // Total number of days (auto-calculated)
            $table->integer('days')->nullable();
            
            // Subject of the leave
            $table->string('subject')->nullable();

            // Reason for the leave
            $table->text('reason');
           



            // Status: pending (default), approved, rejected
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('leave_applications');
    }
    
};
