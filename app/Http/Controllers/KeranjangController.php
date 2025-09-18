<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\Layanan;
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

        $items = Keranjang::with('item')
            ->where('user_id', $user->id)
            ->get();

        return view('keranjang.index', compact('items'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'item_id'   => 'required|integer',
            'item_type' => 'required|in:barang,jasa',
            'jumlah'  => 'nullable|integer|min:1',
        ]);

        $jumlah = $request->item_type === 'barang'
            ? ($request->jumlah ?? 1)
            : 1; // jasa default 1

        Keranjang::updateOrCreate(
            [
                'user_id'   => auth()->id(),
                'item_id'   => $request->item_id,
                'item_type' => $request->item_type,
            ],
            [
                'jumlah' => DB::raw("jumlah + $jumlah"),
            ]
        );

        return back()->with('success', ucfirst($request->item_type) . ' berhasil ditambahkan ke keranjang!');

        // if (!Auth::check()) {
        //     return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        // }

        // $barangId = $request->input('barang_id');
        // $jumlah = $request->input('jumlah') < 1 ? 1 : $request->input('jumlah');
        // $action = $request->input('action');

        // $existingItem = Keranjang::where('user_id', Auth::id())
        //     ->where('barang_id', $barangId)
        //     ->first();

        // $existingLayanan = Keranjang::where('user_id', Auth::id())
        //     ->where('');

        // if ($action === 'keranjang') {
        //     if ($existingItem) {
        //         $existingItem->jumlah += $jumlah;
        //         $existingItem->save();
        //     } else {
        //         Keranjang::create([
        //             'user_id' => Auth::id(),
        //             'barang_id' => $barangId,
        //             'jumlah' => $jumlah,
        //         ]);
        //     }
        //     return redirect()->back()->with('success', 'Barang ditambahkan ke keranjang.');
        // } elseif ($action === 'beli') {
        //     return redirect()->route('checkout', ['barang_id' => $barangId, 'jumlah' => $jumlah]);
        // }
    }

    public function hapus(Request $request, $id)
    {
        $userId = auth()->id();

        $item = Keranjang::where('id', $id)
            ->where('user_id', $userId)
            ->where('item_type', $request->input('item_type'))
            ->where('item_id', $request->input('item_id'))
            ->firstOrFail();

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

        $itemId = $request->query('item_id'); // bisa barang/jasa
        $itemType = $request->query('item_type'); // "barang" atau "jasa"
        $jumlah = $request->query('jumlah', 1);

        $hasOrder = Transaksi::where('user_id', $user->id)->exists();

        // CASE 1: Beli langsung (langsung dari detail barang/jasa)
        if ($itemId && $itemType) {
            if ($itemType === 'barang') {
                $itemData = Barang::find($itemId);
            } elseif ($itemType === 'jasa') {
                $itemData = Layanan::find($itemId);
            } else {
                return redirect()->back()->with('error', 'Tipe item tidak valid.');
            }

            if (!$itemData) {
                return redirect()->back()->with('error', ucfirst($itemType) . ' tidak ditemukan.');
            }

            $item = (object)[
                'item' => $itemData,
                'jumlah' => $jumlah,
                'item_type' => $itemType
            ];

            $total = $itemData->harga * $jumlah;

            return view('keranjang.checkout', [
                'items' => collect([$item]), // dibungkus biar mirip collection
                'total' => $total,
                'hasOrder' => $hasOrder,
                'isDirectBuy' => true,
            ]);
        }

        // CASE 2: Checkout dari keranjang
        $items = Keranjang::with('item') // pastikan relasi polymorphic barang/jasa
            ->where('user_id', $user->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $items->reduce(function ($carry, $item) {
            if ($item->item) {
                return $carry + ($item->item->harga * $item->jumlah);
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
        $isDirectBuy = $request->input('direct_buy') == 1;

        if ($isDirectBuy) {
            // Ambil item_type (barang/jasa) dan id
            $itemType = $request->input('item_type'); // "barang" atau "jasa"
            $itemId   = $request->input('item_id');
            $jumlah   = max(1, (int)$request->input('jumlah', 1));

            // Ambil data item sesuai tipe
            if ($itemType === 'barang') {
                $itemData = Barang::find($itemId);
            } elseif ($itemType === 'jasa') {
                $itemData = Layanan::find($itemId);
            } else {
                return redirect()->back()->with('error', 'Tipe item tidak valid.');
            }

            if (!$itemData) {
                return redirect()->back()->with('error', ucfirst($itemType) . ' tidak ditemukan.');
            }

            // Validasi stok (khusus barang)
            if ($itemType === 'barang' && $itemData->stok < $jumlah) {
                return redirect()->back()->with('error', "Stok untuk '{$itemData->nama}' tidak mencukupi.");
            }

            DB::transaction(function () use ($user, $itemData, $jumlah, $itemType) {
                if ($itemType === 'barang') {
                    $itemData->stok -= $jumlah;
                    $itemData->save();
                }

                $tanggal = Carbon::now()->format('Ymd');
                $jumlahHariIni = Transaksi::whereDate('created_at', Carbon::today())->count() + 1;
                $nomorFaktur = $tanggal . str_pad($jumlahHariIni, 4, '0', STR_PAD_LEFT);

                $transaksi = Transaksi::create([
                    'user_id' => $user->id,
                    'nomor_faktur' => $nomorFaktur,
                    'total_harga' => $itemData->harga * $jumlah,
                    'status' => 'menunggu',
                ]);

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'item_id' => $itemData->id,
                    'item_type' => ucfirst($itemType), // "Barang" atau "Jasa"
                    'jumlah' => $jumlah,
                    'harga' => $itemData->harga,
                    'subtotal' => $itemData->harga * $jumlah,
                ]);
            });

            return redirect()->route('index')->with('success', 'Checkout berhasil! Terima kasih telah berbelanja.');
        }

        // CASE: Checkout dari keranjang
        $items = Keranjang::with('item')->where('user_id', $user->id)->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Validasi stok (hanya untuk barang)
        foreach ($items as $item) {
            if ($item->item_type === 'barang' && $item->item->stok < $item->jumlah) {
                return redirect()->route('keranjang.index')->with('error', "Stok untuk '{$item->item->nama}' tidak mencukupi.");
            }
        }

        DB::transaction(function () use ($user, $items) {
            $totalHarga = 0;

            foreach ($items as $item) {
                if ($item->item_type === 'barang') {
                    $item->item->stok -= $item->jumlah;
                    $item->item->save();
                }

                $totalHarga += $item->item->harga * $item->jumlah;
            }

            $tanggal = Carbon::now()->format('Ymd');
            $jumlahHariIni = Transaksi::whereDate('created_at', Carbon::today())->count() + 1;
            $nomorFaktur = $tanggal . str_pad($jumlahHariIni, 4, '0', STR_PAD_LEFT);

            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'nomor_faktur' => $nomorFaktur,
                'total_harga' => $totalHarga,
                'status' => 'menunggu',
            ]);

            foreach ($items as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'item_id' => $item->item_id,
                    'item_type' => ucfirst($item->item_type),
                    'jumlah' => $item->jumlah,
                    'harga' => $item->item->harga,
                    'subtotal' => $item->item->harga * $item->jumlah,
                ]);
            }

            Keranjang::where('user_id', $user->id)->delete();
        });

        return redirect()->route('index')->with('success', 'Checkout berhasil! Terima kasih telah berbelanja.');
    }
}
