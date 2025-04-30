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
        return $this->belongsTo(JenisBarang::class, 'id_jenis_barang');
    }

}
