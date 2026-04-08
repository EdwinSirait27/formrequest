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
        Schema::table('request_approval', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_approval', function (Blueprint $table) {
    $table->uuid('capex_approver')->nullable()->before('approver1');
    $table->timestamp('capex_approver_at')->nullable()->before('approver1_at');
        });
    }
};
