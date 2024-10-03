<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->onDelete('cascade');
            $table->integer('month');
            $table->integer('year');
            $table->decimal('total_hours', 8, 2);
            $table->decimal('total_overtime_hours', 8, 2);
            $table->decimal('total_public_holiday_hours', 8, 2);
            $table->decimal('total_salary', 10, 2);
            $table->timestamps();
            $table->unique(['staff_id', 'month', 'year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('salaries');
    }
};
