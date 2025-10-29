<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leavesheet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ✅ required column
            $table->date('start_date');
            $table->date('end_date');
            $table->string('leave_type');
            $table->integer('total_days');
            $table->text('reason')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leavesheet');
    }
};
