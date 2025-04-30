<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    protected $table = 'jenis_barang';
    protected $fillable = ['jenis'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_jenis_barang');
    }
}
