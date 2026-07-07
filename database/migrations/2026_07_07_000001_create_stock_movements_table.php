<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->unsignedTinyInteger('type')->comment('1=Shop, 2=Warehouse');
            $table->unsignedBigInteger('location')->comment('Shop or Warehouse ID');
            $table->integer('quantity_before')->default(0);
            $table->integer('quantity_change')->comment('Positive for addition, negative for deduction');
            $table->integer('quantity_after')->default(0);
            $table->string('reference_type')->comment('opening_stock, stock_update, stock_delete, sale, transfer_out, transfer_in, return');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index('created_at');
            $table->index('reference_type');
            $table->index(['product_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
