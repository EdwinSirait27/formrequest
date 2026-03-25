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
        Schema::create('request_approval', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('request_id');
       $table->foreign('request_id')
                ->references('id')
                ->on('form_request')
                ->cascadeOnDelete();
    $table->uuid('approver1')->nullable();
    $table->uuid('approver2')->nullable();
    $table->timestamp('approver1_at')->nullable();
    $table->timestamp('approver2_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_approval');
    }
};
