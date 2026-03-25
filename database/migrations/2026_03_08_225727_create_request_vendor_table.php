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
      Schema::create('request_vendor', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('request_item_id');
     $table->foreign('request_item_id')
                ->references('id')
                ->on('form_request')
                ->cascadeOnDelete();
    $table->uuid('vendor_id');
     $table->foreign('vendor_id')
                ->references('id')
                ->on('vendor')
                ->cascadeOnDelete();
    $table->decimal('price',15,2)->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
});
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_vendor');
    }
};
