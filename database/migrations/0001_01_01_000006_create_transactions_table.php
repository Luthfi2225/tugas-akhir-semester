<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('invoice_number')->unique();

            $table->decimal('total_price', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
