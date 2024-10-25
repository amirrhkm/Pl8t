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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('do_id');
            $table->date('submit_date');
            $table->date('receive_date')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->string('type');
            $table->string('status');
            $table->string('remarks')->nullable();
            $table->integer('estimation_days_to_receive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};