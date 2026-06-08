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
             $table->uuid('pr_approver')->nullable()->after('approver2_at');
    $table->timestamp('pr_approver_at')->nullable()->after('pr_approver');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_approval', function (Blueprint $table) {
            //
        });
    }
};
