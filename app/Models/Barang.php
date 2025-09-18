<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = ['nama', 'foto', 'deskripsi', 'id_jenis_barang', 'harga', 'stok'];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'id_jenis_barang', 'id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'item_id')
            ->where('item_type', 'Barang');
        // karena di DetailTransaksi ada kolom item_type (Barang/Jasa)
    }
}
