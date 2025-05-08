<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('user')->latest()->paginate(10);
        return view('transaksi.index', compact('transaksi'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.barang', 'user')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function konfirmasi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'dibayar';
        $transaksi->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dikonfirmasi.');
    }
}
