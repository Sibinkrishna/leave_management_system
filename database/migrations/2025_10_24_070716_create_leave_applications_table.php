<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('leave_type_id');

            $table->date('start_date');
            $table->date('end_date');

            // NEW COLUMN ADDED
            $table->string('day_type')->default('full');
            // Values: full, half_fn, half_an

            // UPDATED → allow half-day (0.50)
            $table->decimal('days', 4, 2)->nullable();

            $table->string('subject')->nullable();
            $table->text('reason');

            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');

            $table->unsignedBigInteger('approved_by')->nullable();
            $table->date('approval_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('leave_applications');
    }
};
