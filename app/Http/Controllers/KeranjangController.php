<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;

class KeranjangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // $user = auth()->user();

        $hasOrder = Transaksi::where('user_id', $user->id)->exists();

        $items = Keranjang::with('barang') // ambil relasi barang
            ->where('user_id', $user->id)
            ->get();

        return view('keranjang.index', compact('items', 'hasOrder'));
    }

    public function tambah(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $barangId = $request->input('barang_id');
        $jumlah = $request->input('jumlah');
        $action = $request->input('action');

        // Tambahkan ke keranjang (atau langsung beli)
        // Logika sesuai kebutuhan
        // Contoh sederhana:
        if ($action === 'keranjang') {
            // Simpan ke tabel keranjang
            Keranjang::create([
                'user_id' => Auth::id(),
                'barang_id' => $barangId,
                'jumlah' => $jumlah,
            ]);
            return redirect()->back()->with('success', 'Barang ditambahkan ke keranjang.');
        } elseif ($action === 'beli') {
            // Arahkan ke halaman checkout langsung
            return redirect()->route('checkout', ['barang_id' => $barangId, 'jumlah' => $jumlah]);
        }
    }

    public function hapus($id)
    {
        $item = Keranjang::findOrFail($id);

        // Pastikan hanya user pemilik keranjang yang bisa menghapus
        if ($item->user_id !== Auth::id()) {
            return redirect()->route('keranjang.index')->with('error', 'Akses ditolak.');
        }

        $item->delete();

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil dihapus dari keranjang.');
    }


    public function checkout()
    {
        $user = Auth::user();

        $hasOrder = Transaksi::where('user_id', $user->id)->exists();

        $items = Keranjang::with('barang')
            ->where('user_id', $user->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $items->sum(fn($item) => $item->barang->harga * $item->jumlah);

        return view('keranjang.checkout', compact('items', 'total', 'hasOrder'));
    }

    public function prosesCheckout()
    {
        $user = Auth::user();
        $items = Keranjang::with('barang')->where('user_id', $user->id)->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        $totalHarga = 0;

        foreach ($items as $item) {
            $barang = $item->barang;

            if ($barang->stok < $item->jumlah) {
                return redirect()->route('keranjang.index')
                    ->with('error', "Stok untuk '{$barang->nama}' tidak mencukupi.");
            }

            // Kurangi stok barang
            $barang->stok -= $item->jumlah;
            $barang->save();

            $totalHarga += $barang->harga * $item->jumlah;
        }

        // Generate nomor faktur: format YYYYMMDD0001
        $tanggal = Carbon::now()->format('Ymd');
        $jumlahHariIni = Transaksi::whereDate('created_at', Carbon::today())->count() + 1;
        $nomorFaktur = $tanggal . str_pad($jumlahHariIni, 4, '0', STR_PAD_LEFT);

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'nomor_faktur' => $nomorFaktur,
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
        ]);

        // Simpan detail transaksi
        foreach ($items as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $item->barang_id,
                'jumlah' => $item->jumlah,
                'harga' => $item->barang->harga,
                'subtotal' => $item->barang->harga * $item->jumlah,
            ]);
        }

        // KOsongkan keranjang user
        Keranjang::where('user_id', $user->id)->delete();

        return redirect()->route('etalase')->with('success', 'Checkout berhasil! Terima kasih telah berbelanja.');
    }
}
