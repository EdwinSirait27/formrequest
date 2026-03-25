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
           Schema::create('request_attachment', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('request_id');
     $table->foreign('request_id')
                ->references('id')
                ->on('form_request')
                ->cascadeOnDelete();
    $table->string('file_path');
    $table->string('file_name')->nullable();
    $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_attachment');
    }
};
