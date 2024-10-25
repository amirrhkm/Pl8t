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
        Schema::create('sales_eods', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('debit', 10, 2)->nullable();
            $table->decimal('visa', 10, 2)->nullable();
            $table->decimal('master', 10, 2)->nullable();
            $table->decimal('cash', 10, 2)->default(0);
            $table->decimal('ewallet', 10, 2)->default(0);
            $table->decimal('foodpanda', 10, 2)->nullable();
            $table->decimal('grabfood', 10, 2)->nullable();
            $table->decimal('shopeefood', 10, 2)->nullable();
            $table->decimal('prepaid', 10, 2)->nullable();
            $table->decimal('voucher', 10, 2)->nullable();
            $table->decimal('total_sales', 10, 2)->default(0);
            $table->decimal('amount_to_bank_in', 10, 2)->nullable();
            $table->decimal('cash_difference', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_eods');
    }
};