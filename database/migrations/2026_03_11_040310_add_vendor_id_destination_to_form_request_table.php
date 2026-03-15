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
        $table->uuid('vendor_id')->nullable()->after('request_type_id');
             $table->foreign('vendor_id')
              ->references('id')
              ->on('vendor')
              ->cascadeOnDelete();
        $table->string('destination')->nullable()->after('document_number');
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
