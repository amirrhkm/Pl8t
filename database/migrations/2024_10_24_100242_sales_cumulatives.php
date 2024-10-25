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
        Schema::create('sales_cumulatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_eod_id')->nullable();
            $table->unsignedBigInteger('sales_bankin_id')->nullable();
            $table->unsignedBigInteger('sales_earning_id')->nullable();
            $table->unsignedBigInteger('sales_expense_id')->nullable();
            $table->date('date');
            $table->decimal('total_bankin_amount', 10, 2)->default(0);
            $table->timestamps();
            
            $table->foreign('sales_eod_id')->references('id')->on('sales_eods');
            $table->foreign('sales_bankin_id')->references('id')->on('sales_bankins');
            $table->foreign('sales_earning_id')->references('id')->on('sales_earnings');
            $table->foreign('sales_expense_id')->references('id')->on('sales_expenses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_cumulatives');
    }
};
