<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            if (!Schema::hasColumn('leaves', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])
                      ->default('pending');
            }
            if (!Schema::hasColumn('leaves', 'admin_comment')) {
                $table->text('admin_comment')->nullable();
            }
            if (!Schema::hasColumn('leaves', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn(['status', 'admin_comment', 'approved_by']);
        });
    }
};
