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
        Schema::create('additional_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items');
            $table->foreignId('additional_product_id')->constrained('products');
            $table->decimal('price')->default(0);
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_order_items');
    }
};
