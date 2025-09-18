<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\Layanan;
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
        $transaksi = Transaksi::with('detailTransaksi.item', 'user')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function riwayat()
    {
        $transaksi = Transaksi::with('detailTransaksi.barang')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('transaksi.riwayat-pesanan', compact('transaksi'));
    }

    public function detail_transaksi($id_transaksi)
    {
        $transaksi = Transaksi::with('detailTransaksi.item', 'user')
            ->where('user_id', auth()->id()) // pastikan transaksi milik user login
            ->findOrFail($id_transaksi);

        return view('transaksi.detail-transaksi', compact('transaksi'));
    }


    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'dibayar' => 'required|string',
        ]);

        // Bersihkan nilai uang dari titik/koma/spasi
        $dibayar = preg_replace('/[^0-9]/', '', $request->dibayar);
        $dibayar = (float) $dibayar;


        $transaksi = Transaksi::findOrFail($id);

        // Validasi dibayar tidak boleh kurang dari total harga
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
        $layanan = Layanan::all();

        return view('transaksi.create', compact('barang', 'layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id'   => 'required|array',
            'jumlah'    => 'required|array',
            'harga'     => 'required|array',
            'subtotal'  => 'required|array',
            'total'     => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Generate nomor faktur: format YYYYMMDD0001
            $tanggal = Carbon::now()->format('Ymd');
            $jumlahHariIni = Transaksi::whereDate('created_at', Carbon::today())->count() + 1;
            $nomorFaktur = $tanggal . str_pad($jumlahHariIni, 4, '0', STR_PAD_LEFT);

            // Bersihkan total (hilangkan simbol selain angka)
            $total = (float) preg_replace('/[^\d]/', '', $request->total);

            $transaksi = Transaksi::create([
                'user_id'      => auth()->id(),
                'nomor_faktur' => $nomorFaktur,
                'total_harga'  => $total,
                'status'       => 'menunggu'
            ]);

            foreach ($request->item_id as $i => $itemValue) {
                [$type, $id] = explode('-', $itemValue);

                $harga    = (float) preg_replace('/[^\d]/', '', $request->harga[$i]);
                $subtotal = (float) preg_replace('/[^\d]/', '', $request->subtotal[$i]);
                $jumlah   = isset($request->jumlah[$i]) ? (int) $request->jumlah[$i] : 1;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'item_id'      => $id,
                    'item_type'    => $type, // 'barang' atau 'layanan'
                    'jumlah'       => $jumlah,
                    'harga'        => $harga,
                    'subtotal'     => $subtotal,
                ]);

                // Kalau barang, kurangi stok
                if ($type === 'barang') {
                    $barang = Barang::find($id);

                    if (!$barang) {
                        throw new \Exception("Barang dengan ID $id tidak ditemukan.");
                    }

                    if ($barang->stok < $jumlah) {
                        throw new \Exception("Stok barang {$barang->nama} tidak mencukupi.");
                    }

                    $barang->stok -= $jumlah;
                    $barang->save();
                }
            }

            DB::commit();
            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
