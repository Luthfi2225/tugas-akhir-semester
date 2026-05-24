<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->onDelete('cascade');

            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->string('product_name');
            $table->integer('stock')->default(0);
            $table->decimal('price', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
