<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pending_leaves', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('leave_type_id');

            $table->year('year');

            // ✔ Support decimals like 0.5, 1.5, etc.
            $table->decimal('total', 5, 1)->default(0.0);
            $table->decimal('used', 5, 1)->default(0.0);
            $table->decimal('remaining', 5, 1)->default(0.0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_leaves');
    }
};
