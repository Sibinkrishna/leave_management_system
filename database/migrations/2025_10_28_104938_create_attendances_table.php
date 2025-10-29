<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date');            // date of record (Y-m-d)
            $table->timestamp('check_in')->nullable();  // check-in timestamp
            $table->timestamp('check_out')->nullable(); // check-out timestamp
            $table->string('status')->default('present'); // present/absent/remote etc.
            $table->integer('duration_minutes')->nullable(); // total minutes worked
            $table->timestamps();

            $table->unique(['user_id', 'attendance_date']); // one record per day per user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
