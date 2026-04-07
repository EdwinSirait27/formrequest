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
        $table->uuid('towards_to')->nullable()->after('user_id');
        $table->enum('assets',[
            'Bangunan',
            'Peralatan & Inventaris',
            'IT Hardware & Software',
            'Kendaraan',
            'Machine & Equipment'
        ])->nullable()->before('status');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_request', function (Blueprint $table) {
        });
    }
};