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
            // $table->string('payment_type_payreq')->nullable()->after('assets');
             $table->enum('payment_type_payreq',[
            'Monthly',
            'Quarterly',
            'Semiannual',
            'Annually'
        ])->nullable()->before('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_request', function (Blueprint $table) {
            //
        });
    }
};
