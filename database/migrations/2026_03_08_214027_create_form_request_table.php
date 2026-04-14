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
        Schema::create('form_request', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('request_type_id');
        $table->foreign('request_type_id')
              ->references('id')
              ->on('request_type')
              ->cascadeOnDelete();
        $table->string('document_number')->nullable()->index();
        $table->date('request_date');
        $table->uuid('user_id')->nullable()->index();
        $table->decimal('total_amount',15,2)->default(0);
        $table->text('notes')->nullable();
        $table->enum('status',[
            'draft',
            'submitted',
            'approved manager',
            'approved it',
            'approved bd',
            'rejected manager',
            'approved finance',
            'rejected finance'
        ])->nullable();
        $table->timestamps();
    });
 }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_request');
    }
};
