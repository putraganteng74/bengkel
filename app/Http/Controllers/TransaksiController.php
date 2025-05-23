<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'dibayar' => 'required|string',
        ]);

        // Bersihkan nilai 'dibayar' dari titik/koma/spasi
        $dibayar = (float) str_replace(['.', ',', ' '], '', $request->dibayar);

        $transaksi = Transaksi::findOrFail($id);

        // Pastikan jumlah yang dibayar tidak kurang dari total harga
        if ($dibayar < $transaksi->total_harga) {
            return back()->with('error', 'Jumlah yang dibayar kurang dari total harga.');
        }

        $transaksi->status = 'dibayar';
        $transaksi->dibayar = $dibayar;
        $transaksi->kembalian = $dibayar - $transaksi->total_harga;
        $transaksi->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dikonfirmasi.');
    }

    public function create()
    {
        $barang = Barang::all(); // Ambil semua barang untuk ditampilkan dalam select

        return view('transaksi.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
            'harga' => 'required|array',
            'subtotal' => 'required|array',
            'total' => 'required',
        ]);

        // dd($request);

        DB::beginTransaction();

        // Generate nomor faktur: format YYYYMMDD0001
        $tanggal = Carbon::now()->format('Ymd');
        $jumlahHariIni = Transaksi::whereDate('created_at', Carbon::today())->count() + 1;
        $nomorFaktur = $tanggal . str_pad($jumlahHariIni, 4, '0', STR_PAD_LEFT);

        try {
            $clean = preg_replace('/[^\d,]/u', '', $request->total);
            $clean = str_replace(',', '.', $clean);
            $hargaBaru = number_format((float) $clean, 2, '.', '');


            $transaksi = Transaksi::create([
                'user_id' => auth()->id(),
                'nomor_faktur' => $nomorFaktur,
                'total_harga' => $hargaBaru,
                'status' => 'menunggu'
            ]);

            foreach ($request->barang_id as $i => $barangId) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barangId,
                    'jumlah' => $request->jumlah[$i],
                    'harga' => $request->harga[$i],
                    'subtotal' => $request->subtotal[$i],
                ]);

                // Kurangi stok
                $barang = Barang::find($barangId);
                $barang->stok -= $request->jumlah[$i];
                $barang->save();
            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
