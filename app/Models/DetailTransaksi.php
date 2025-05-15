<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'jumlah',
        'harga',
        'subtotal',
    ];

    // Relasi ke transaksi (banyak ke satu)
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Relasi ke barang (banyak ke satu)
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
