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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('delivery_address_id')->nullable()->constrained('addresses');
            $table->enum('status', ['pending_approval', 'canceled', 'preparing', 'reversed', 'concluded'])->nullable();
            $table->enum('payment_method', ['credit_card', 'cash'])->nullable();
            $table->decimal('manual_discount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
