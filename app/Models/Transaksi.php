<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    // Kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'nomor_faktur',
        'user_id',
        'total_harga',
        'status',
    ];

    // Relasi: satu transaksi memiliki banyak detail
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    // (Opsional) Relasi ke User, jika kamu ingin tahu siapa yang memesan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
