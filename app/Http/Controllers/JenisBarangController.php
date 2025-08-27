<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JenisBarangController extends Controller
{
    // Menampilkan daftar jenis barang
    public function index()
    {
        $jenisbarang = JenisBarang::all();
        return view('jenis_barang.index', compact('jenisbarang'));
    }

    // Menampilkan form tambah jenis barang
    public function create()
    {
        return view('jenis_barang.tambah');
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang' => 'required|string|max:255'
        ]);

        $slug = Str::slug($request->jenis_barang);

        JenisBarang::create([
            'jenis' => $request->jenis_barang,
            'slug' => $slug
        ]);

        return redirect()->route('jenis-barang.index')->with('success', 'Jenis Barang berhasil ditambahkan!');
    }

    // Menampilkan form edit jenis barang
    public function edit($id)
    {
        $jenisbarang = JenisBarang::findOrFail($id);
        return view('jenis_barang.edit', compact('jenisbarang'));
    }

    // Menyimpan perubahan ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string|max:255'
        ]);

        $slug = Str::slug($request->jenis);

        $jenisbarang = JenisBarang::findOrFail($id);
        $jenisbarang->update([
            'jenis' => $request->jenis,
            'slug' => $slug
        ]);

        return redirect()->route('jenis-barang.index')->with('success', 'Jenis Barang berhasil diperbarui!');
    }

    // Menghapus jenis barang
    public function destroy($id)
    {
        $jenisbarang = JenisBarang::findOrFail($id);
        $jenisbarang->delete();

        return redirect()->route('jenis-barang.index')->with('success', 'Jenis Barang berhasil dihapus!');
    }
}
