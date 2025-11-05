<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('work_from_home_entries', function (Blueprint $table) {
            $table->date('entry_date')->nullable()->after('user_id');
            $table->string('work_time')->nullable()->after('entry_date');
        });
    }

    public function down()
    {
        Schema::table('work_from_home_entries', function (Blueprint $table) {
            $table->dropColumn(['entry_date', 'work_time']);
        });
    }
};
