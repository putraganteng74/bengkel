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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id(); // ID auto-increment primary key
            $table->string('nama_layanan'); // Nama layanan
            $table->text('deskripsi')->nullable(); // Deskripsi layanan
            $table->integer('durasi'); // Durasi layanan dalam menit
            $table->decimal('harga', 10, 2); // Harga layanan
            $table->timestamps(); // Waktu pembuatan dan update data
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanans');
    }
};
