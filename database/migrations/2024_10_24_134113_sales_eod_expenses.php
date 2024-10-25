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
        Schema::create('sales_eod_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_eod_id')->constrained('sales_eods');
            $table->date('date');
            $table->string('expenses_1')->nullable();
            $table->decimal('amount_1', 10, 2)->nullable();
            $table->string('expenses_2')->nullable();
            $table->decimal('amount_2', 10, 2)->nullable();
            $table->string('expenses_3')->nullable();
            $table->decimal('amount_3', 10, 2)->nullable();
            $table->string('expenses_4')->nullable();
            $table->decimal('amount_4', 10, 2)->nullable();
            $table->string('expenses_5')->nullable();
            $table->decimal('amount_5', 10, 2)->nullable();
            $table->string('expenses_6')->nullable();
            $table->decimal('amount_6', 10, 2)->nullable();
            $table->string('expenses_7')->nullable();
            $table->decimal('amount_7', 10, 2)->nullable();
            $table->string('expenses_8')->nullable();
            $table->decimal('amount_8', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_eod_expenses');
    }
};
