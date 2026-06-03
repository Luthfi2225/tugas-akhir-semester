<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->integer('quantity');
            $table->integer('beginning_stock');
            $table->integer('ending_stock');

            $table->enum('type', ['stock_in', 'stock_out', 'sales_pos', 'adjustment', 'transfer'])->default('stock_in')->index();
            $table->string('reference_number')->nullable();

            $table->enum('reason', ['damaged', 'expired', 'lost', 'transfer', 'stolen', 'none'])->default('none')->index();

            $table->text('notes')->nullable();
            $table->timestamp('transaction_date')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_histories');
    }
};
