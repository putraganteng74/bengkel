<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\Transaksi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function etalase()
    {
        $user = auth()->user();
        $barang = Barang::all();

        if ($user) {
            $hasOrder = Transaksi::where('user_id', $user->id)->exists();
            return view('barang.etalase', compact('barang', 'hasOrder'));
        } else {
            return view('barang.etalase', compact('barang'));
        }
    }

    public function index()
    {
        // Mengambil semua data dari tabel barang
        // $barang = Barang::all();
        $barang = Barang::with('jenisBarang')->paginate(10);

        // Mengirim data ke view
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $jenis = JenisBarang::all();
        return view('barang.tambah', compact('jenis'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'required|string',
            'id_jenis_barang' => 'required|numeric',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
        }

        // Simpan data ke database
        Barang::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'id_jenis_barang' => $request->id_jenis_barang,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $fotoPath,
        ]);

        // Redirect ke halaman daftar barang
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Menampilkan form edit jenis barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $jenis = JenisBarang::all();
        return view('barang.edit', compact('barang', 'jenis'));
    }

    // Menyimpan perubahan ke database
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required|string',
            'id_jenis_barang' => 'required|numeric',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        // Ambil data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Jika ada file foto yang di-upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto && Storage::exists('public/' . $barang->foto)) {
                Storage::delete('public/' . $barang->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $barang->foto = $fotoPath;
        }

        // Update data barang
        $barang->update([
            'nama' => $request->nama,
            'foto' => $barang->foto,
            'deskripsi' => $request->deskripsi,
            'id_jenis_barang' => $request->id_jenis_barang,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }


    // Menghapus jenis barang
    public function destroy($id)
    {
        $jenisbarang = Barang::findOrFail($id);
        $jenisbarang->delete();

        return redirect()->route('barang.index')->with('success', 'Jenis Barang berhasil dihapus!');
    }

    public function show($id)
    {
        $barang = Barang::with('jenisBarang')->findOrFail($id);

        return view('barang.detail', compact('barang'));
    }

    public function showEtalase($id)
    {
        $barang = Barang::findOrFail($id);

        $user = auth()->user();

        $hasOrder = Transaksi::where('user_id', $user->id)->exists();

        return view('barang.t_etalase', compact('barang', 'hasOrder'));
    }
}
