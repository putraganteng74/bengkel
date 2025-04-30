<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->text('foto');
            $table->text('deskripsi');
            $table->foreignId('id_jenis_barang')->constrained('jenis_barang')->onDelete('cascade');
            $table->decimal('harga', 7,2);
            $table->integer('stok')->unsigned;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
};
