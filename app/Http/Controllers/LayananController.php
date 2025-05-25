<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    // Menampilkan semua layanan
    public function index()
    {
        $layanans = Layanan::paginate(10); // Mengambil semua data layanan
        return view('layanans.index', compact('layanans')); // Mengirim data ke view
    }

    // Menampilkan form untuk menambah layanan
    public function create()
    {
        return view('layanans.create');
    }

    // Menyimpan layanan baru
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'durasi' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        // Menyimpan layanan ke database
        Layanan::create($validated);

        return redirect()->route('layanans.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function show($id)
    {
        {
            $layanan = Layanan::findOrFail($id);

            $user = auth()->user();

            if ($user) {
                $hasOrder = Transaksi::where('user_id', $user->id)->exists();
            } else {
                $hasOrder = false;
            }

            return view('layanans.detail', compact('layanan', 'hasOrder'));
        }
    }

    // Menampilkan form untuk mengedit layanan
    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('layanans.edit', compact('layanan'));
    }

    // Menyimpan perubahan layanan
    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'durasi' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        // Menemukan layanan berdasarkan ID dan memperbarui data
        $layanan = Layanan::findOrFail($id);
        $layanan->update($validated);

        return redirect()->route('layanans.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    // Menghapus layanan
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('layanans.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
