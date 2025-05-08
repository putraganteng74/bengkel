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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_faktur')->unique(); // Nomor faktur unik
            $table->decimal('total_harga', 7, 2); // Total harga transaksi
            $table->decimal('dibayar', 7, 2)->nullable(); // Total harga transaksi
            $table->decimal('kembalian', 5, 2)->nullable(); // Total harga transaksi
            $table->timestamps(); // created_at dan updated_at
        });

        // Tabel detail transaksi
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->foreignId('id_transaksi')->constrained('transaksi')->onDelete('cascade'); // Relasi ke tabel transaksi
            $table->foreignId('id_barang')->constrained('barang')->onDelete('cascade'); // Relasi ke tabel barang/jasa
            $table->integer('jumlah');
            $table->decimal('harga', 7, 2);
            $table->decimal('subtotal', 7, 2);
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
        
        Schema::dropIfExists('detail_transaksi');
        Schema::dropIfExists('transaksi');
    }
};
