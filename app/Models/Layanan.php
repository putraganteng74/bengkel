<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'durasi',
        'harga',
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'item_id')
            ->where('item_type', 'jasa');
        // karena di DetailTransaksi ada kolom item_type (Barang/Jasa)
    }
}
