<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->date('date'); // Tanggal transaksi
            $table->integer('amount'); // Jumlah uang
            $table->enum('type', ['income', 'expense']); // Pemasukan atau pengeluaran
            $table->unsignedBigInteger('category_id'); // Foreign Key ke categories
            $table->text('note')->nullable(); // Catatan tambahan
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
        Schema::dropIfExists('transactions');
    }
}
