<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('work_from_home_entries', function (Blueprint $table) {
            $table->id();

            // ✅ Link to user
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // ✅ Work From Home Fields
            $table->date('entry_date')->nullable();       // Work date
            $table->string('work_time')->nullable();      // Time slot (e.g. 1:30 PM)
            $table->text('task_summary')->nullable();     // Task summary
            $table->string('notes')->nullable();          // Work status (Working, Completed, Lunch Time)

            // ✅ Optional integration fields
            $table->boolean('pushed_to_sheet')->default(false);
            $table->string('sheet_row_id')->nullable();

            // ✅ Laravel timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_from_home_entries');
    }
};
