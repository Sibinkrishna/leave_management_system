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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Example: Casual Leave, Sick Leave, Earned Leave
            $table->integer('total_days_per_year'); // Total leave allowed per year
            $table->boolean('carry_forward')->default(0); // 0 = No, 1 = Yes
            $table->text('description')->nullable(); // Optional description
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
