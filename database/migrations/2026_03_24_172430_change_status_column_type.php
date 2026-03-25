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
         Schema::table('form_request', function (Blueprint $table) {
     $table->enum('status',[
            'Draft',
            'Submitted',
            'Approved Manager',
            'Rejected Manager',
            'Approved Finance',
            'Rejected Finance',
            'Rejected Director',
            'Approved Director',
            'Done'
        ])->nullable()->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('form_request', function (Blueprint $table) {

        $table->enum('status',[
            'draft',
            'submitted',
            'approved manager',
            'rejected manager',
            'approved finance',
            'rejected finance'
        ])->nullable()->change();
    });
    }
};
