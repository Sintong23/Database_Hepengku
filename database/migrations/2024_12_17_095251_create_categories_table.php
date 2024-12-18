<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Nama kategori
            $table->enum('type', ['income', 'expense']); // Jenis kategori (pemasukan atau pengeluaran)
            $table->string('icon')->nullable(); // Nama file ikon (opsional)
            $table->timestamps(); // created_at, updated_a
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
