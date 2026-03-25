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
        Schema::create('request_item', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('request_id');
            $table->foreign('request_id')
                ->references('id')
                ->on('form_request')
                ->cascadeOnDelete();
            $table->string('item_name');
            $table->text('specification')->nullable();
            $table->integer('qty')->nullable();
             $table->enum('uom',[
            'pieces',
            'unit',
            'set',
            'pack',
            'box',
            'rim',
            'kg',
            'liter',
            'meter',
            'roll'
        ])->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('total_price', 15, 2)->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_item');
    }
};
