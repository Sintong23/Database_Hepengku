<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('category_id'); // Foreign Key ke categories
            $table->integer('amount'); // Jumlah anggaran
            $table->string('month', 7); // Bulan dalam format YYYY-MM
            $table->timestamps(); // created_at, updated_at
            // Relasi
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budgets');
    }
}
