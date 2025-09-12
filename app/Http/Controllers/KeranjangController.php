<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $items = Keranjang::with('barang') // ambil relasi barang
            ->where('user_id', $user->id)
            ->get();

        return view('keranjang.index', compact('items'));
    }

    public function tambah(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $barangId = $request->input('barang_id');
        $jumlah = $request->input('jumlah') < 1 ? 1 : $request->input('jumlah');
        $action = $request->input('action');

        $existingItem = Keranjang::where('user_id', Auth::id())
                    ->where('barang_id', $barangId)
                    ->first();

        if ($action === 'keranjang') {
            if ($existingItem) {
                $existingItem->jumlah += $jumlah;
                $existingItem->save();
            } else {
                Keranjang::create([
                    'user_id' => Auth::id(),
                    'barang_id' => $barangId,
                    'jumlah' => $jumlah,
                ]);
            }
            return redirect()->back()->with('success', 'Barang ditambahkan ke keranjang.');
        } elseif ($action === 'beli') {
            // Simpan ke tabel keranjang
            // Keranjang::create([
            //     'user_id' => Auth::id(),
            //     'barang_id' => $barangId,
            //     'jumlah' => $jumlah,
            // ]);
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


    public function checkout(Request $request)
    {
        $user = Auth::user();

        $barangId = $request->query('barang_id');
        $jumlah = $request->query('jumlah', 1); // default 1 jika tidak diisi

        $hasOrder = Transaksi::where('user_id', $user->id)->exists();

        // CASE 1: Beli langsung
        if ($barangId) {
            $barang = Barang::find($barangId);

            if (!$barang) {
                return redirect()->back()->with('error', 'Barang tidak ditemukan.');
            }

            $item = (object)[
                'barang' => $barang,
                'jumlah' => $jumlah
            ];

            $total = $barang->harga * $jumlah;

            return view('keranjang.checkout', [
                'items' => collect([$item]), // buat seperti koleksi keranjang
                'total' => $total,
                'hasOrder' => $hasOrder,
                'isDirectBuy' => true, // tambahan untuk dibedakan di view jika perlu
            ]);
        }

        // CASE 2: Checkout dari keranjang
        $items = Keranjang::with('barang')
            ->where('user_id', $user->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $items->reduce(function ($carry, $item) {
            if ($item->barang) {
                return $carry + ($item->barang->harga * $item->jumlah);
            }
            return $carry;
        }, 0);

        return view('keranjang.checkout', [
            'items' => $items,
            'total' => $total,
            'hasOrder' => $hasOrder,
            'isDirectBuy' => false,
        ]);
    }

    public function prosesCheckout(Request $request)
    {
        $user = Auth::user();

        // Cek apakah ini beli langsung atau checkout dari keranjang
        $isDirectBuy = $request->input('direct_buy') == 1;

        if ($isDirectBuy) {
            // Ambil data barang dan jumlah dari input
            $barangId = $request->input('barang_id');
            $jumlah = max(1, (int)$request->input('jumlah', 1));

            $barang = Barang::find($barangId);

            if (!$barang) {
                return redirect()->back()->with('error', 'Barang tidak ditemukan.');
            }

            if ($barang->stok < $jumlah) {
                return redirect()->back()->with('error', "Stok untuk '{$barang->nama}' tidak mencukupi.");
            }

            // Transaksi dalam DB transaction agar aman
            DB::transaction(function () use ($user, $barang, $jumlah) {
                // Kurangi stok barang
                $barang->stok -= $jumlah;
                $barang->save();

                // Generate nomor faktur: format YYYYMMDD0001
                $tanggal = Carbon::now()->format('Ymd');
                $jumlahHariIni = Transaksi::whereDate('created_at', Carbon::today())->count() + 1;
                $nomorFaktur = $tanggal . str_pad($jumlahHariIni, 4, '0', STR_PAD_LEFT);

                // Simpan transaksi
                $transaksi = Transaksi::create([
                    'user_id' => $user->id,
                    'nomor_faktur' => $nomorFaktur,
                    'total_harga' => $barang->harga * $jumlah,
                    'status' => 'menunggu',
                ]);

                // Simpan detail transaksi
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $jumlah,
                    'harga' => $barang->harga,
                    'subtotal' => $barang->harga * $jumlah,
                ]);
            });

            return redirect()->route('index')->with('success', 'Checkout berhasil! Terima kasih telah berbelanja.');
        }

        // CASE: Checkout dari keranjang
        $items = Keranjang::with('barang')->where('user_id', $user->id)->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Cek stok semua barang dulu
        foreach ($items as $item) {
            $barang = $item->barang;
            if (!$barang) {
                return redirect()->route('keranjang.index')->with('error', "Barang di keranjang tidak ditemukan.");
            }
            if ($barang->stok < $item->jumlah) {
                return redirect()->route('keranjang.index')->with('error', "Stok untuk '{$barang->nama}' tidak mencukupi.");
            }
        }

        DB::transaction(function () use ($user, $items) {
            $totalHarga = 0;

            // Kurangi stok dan hitung total
            foreach ($items as $item) {
                $barang = $item->barang;
                $barang->stok -= $item->jumlah;
                $barang->save();

                $totalHarga += $barang->harga * $item->jumlah;
            }

            // Generate nomor faktur
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

            // Kosongkan keranjang user
            Keranjang::where('user_id', $user->id)->delete();
        });

        return redirect()->route('index')->with('success', 'Checkout berhasil! Terima kasih telah berbelanja.');
    }

}
