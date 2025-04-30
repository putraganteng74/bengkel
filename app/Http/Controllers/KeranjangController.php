<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{   
    public function index()
    {
        $user = Auth::user();

        $items = Keranjang::with('barang') // ambil relasi barang
            ->where('user_id', $user->id)
            ->get();

        return view('keranjang.index', compact('items'));
    }

    public function tambah(Request $request)
    {
        $barangId = $request->input('barang_id');
        $jumlah = $request->input('jumlah');
        $action = $request->input('action');

        // Tambahkan ke keranjang (atau langsung beli)
        // Logika sesuai kebutuhan
        // Contoh sederhana:
        if ($action === 'keranjang') {
            // Simpan ke tabel keranjang
            // ...
            return redirect()->back()->with('success', 'Barang ditambahkan ke keranjang.');
        } elseif ($action === 'beli') {
            // Arahkan ke halaman checkout langsung
            return redirect()->route('checkout', ['barang_id' => $barangId, 'jumlah' => $jumlah]);
        }
    }

}
