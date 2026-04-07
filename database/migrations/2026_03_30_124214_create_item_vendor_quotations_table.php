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
          Schema::create('item_vendor_quotations', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('request_item_id');
    $table->uuid('vendor_id');
    $table->decimal('price', 18, 2);
    $table->text('notes')->nullable();
    $table->boolean('is_selected')->default(false); // vendor terpilih
    $table->timestamps();
    $table->foreign('request_item_id')->references('id')->on('request_item')->cascadeOnDelete();
    $table->foreign('vendor_id')->references('id')->on('vendor')->cascadeOnDelete();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_vendor_quotations');
    }
};