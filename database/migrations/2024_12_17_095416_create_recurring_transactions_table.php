<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecurringTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurring_transactions', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Nama transaksi berulang
            $table->integer('amount'); // Jumlah uang
            $table->enum('type', ['income', 'expense']); // Pemasukan atau pengeluaran
            $table->unsignedBigInteger('category_id'); // Foreign Key ke categories
            $table->date('start_date'); // Tanggal mulai
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'yearly']); // Frekuensi pengulangan
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
        Schema::dropIfExists('recurring_transactions');
    }
}
