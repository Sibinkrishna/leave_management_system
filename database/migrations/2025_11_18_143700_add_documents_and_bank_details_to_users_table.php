<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bank_name')) {
                $table->string('bank_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'account_number')) {
                $table->string('account_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'ifsc_code')) {
                $table->string('ifsc_code')->nullable();
            }
            if (!Schema::hasColumn('users', 'branch_name')) {
                $table->string('branch_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'adhar_no')) {
                $table->string('adhar_no')->nullable();
            }
            if (!Schema::hasColumn('users', 'pan_no')) {
                $table->string('pan_no')->nullable();
            }
            if (!Schema::hasColumn('users', 'adhar_card')) {
                $table->string('adhar_card')->nullable();
            }
            if (!Schema::hasColumn('users', 'pan_card')) {
                $table->string('pan_card')->nullable();
            }
            if (!Schema::hasColumn('users', 'passport_photo')) {
                $table->string('passport_photo')->nullable();
            }
            if (!Schema::hasColumn('users', 'bank_doc')) {
                $table->string('bank_doc')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bank_name', 'account_number', 'ifsc_code', 'branch_name',
                'adhar_no', 'pan_no', 'adhar_card', 'pan_card', 'passport_photo', 'bank_doc'
            ]);
        });
    }
};
