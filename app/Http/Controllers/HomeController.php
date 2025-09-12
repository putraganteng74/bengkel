<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\JenisBarang;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('jenisBarang')->get();
        $layanans = Layanan::all();

        $categories = DB::table('jenis_barang as jb')
            ->select(
                'jb.id',
                'jb.jenis',
                'jb.slug',
                DB::raw('(SELECT foto FROM barang WHERE id_jenis_barang = jb.id LIMIT 1) as foto')
            )
            ->groupBy('jb.id', 'jb.jenis', 'jb.slug')
            ->get();

        $topProduct = DetailTransaksi::select('barang_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->with('barang')
            ->groupBy('barang_id')
            ->orderByDesc('total_terjual')
            ->first();

        return view('home.index', compact(
            'topProduct',
            'barangs',
            'layanans',
            'categories',
        ));
    }


    public function produk(Request $request)
    {
        $user = auth()->user();
        $keyword = $request->query('q');

        if ($keyword) {
            $barangs = Barang::where('nama', 'like', "%{$keyword}%")
                ->get();
        } else {
            $barangs = Barang::all();
        }

        if ($user) {
            $hasOrder = Transaksi::where('user_id', $user->id)->exists();
        } else {
            $hasOrder = false;
        }

        return view('barang.etalase', compact('barangs', 'hasOrder'));
    }

    public function layanan()
    {
        $user = auth()->user();
        $layanans = Layanan::all();

        if ($user) {
            $hasOrder = Transaksi::where('user_id', $user->id)->exists();
        } else {
            $hasOrder = false;
        }

        return view('layanans.etalase', compact('layanans', 'hasOrder'));
    }

    public function dashboard()
    {   
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $now = Carbon::now();

        // Transaksi Harian
        $totalHarian = Transaksi::whereDate('created_at', $today)->sum('total_harga');
        $totalHarianKemarin = Transaksi::whereDate('created_at', $today->copy()->subDay())->sum('total_harga');
        $persenHarian = $this->hitungPersen($totalHarianKemarin, $totalHarian);

        // Transaksi Bulanan
        $totalBulanan = Transaksi::whereBetween('created_at', [$startOfMonth, $now])->count();
        $startLastMonth = $startOfMonth->copy()->subMonth();
        $endLastMonth = $startOfMonth->copy()->subDay();
        $totalBulananLalu = Transaksi::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $persenBulanan = $this->hitungPersen($totalBulananLalu, $totalBulanan);

        // Pengunjung (user yang pernah transaksi)
        $totalPengunjung = User::whereHas('transaksi')->count();
        // Untuk demo, asumsikan bulan lalu = 3400
        $pengunjungLalu = 3400;
        $persenPengunjung = $this->hitungPersen($pengunjungLalu, $totalPengunjung);

        // Akun baru bulan ini
        $akunBaruBulanIni = User::whereBetween('created_at', [$startOfMonth, $now])->count();
        $akunBaruBulanLalu = User::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $persenAkunBaru = $this->hitungPersen($akunBaruBulanLalu, $akunBaruBulanIni);

        // Data total penjualan per bulan (12 bulan terakhir)
        $monthlySales = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $total = Transaksi::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_harga');
            $monthlySales[] = [
                'label' => $month->format('M Y'),
                'total' => $total
            ];
        }

        // Ambil 2 data terakhir untuk membandingkan bulan ini dan bulan lalu
        $salesLastMonth = $monthlySales[count($monthlySales) - 2]['total'] ?? 0;
        $salesThisMonth = $monthlySales[count($monthlySales) - 1]['total'] ?? 0;

        if ($salesLastMonth > 0) {
            $change = (($salesThisMonth - $salesLastMonth) / $salesLastMonth) * 100;
        } else {
            $change = 100;
        }

        $salesChange = [
            'value' => number_format(abs($change), 1),
            'naik' => $change >= 0
        ];

        $queues = Antrian::whereDate('waktu_datang', Carbon::today())
            ->with('user')
            ->orderBy('waktu_datang', 'asc')
            ->get();

        // Jika tidak ada yang 'diproses', set yang pertama 'menunggu' jadi 'diproses'
        if (!$queues->contains('status', 'diproses')) {
            $firstWaiting = $queues->firstWhere('status', 'menunggu');
            if ($firstWaiting) {
                $firstWaiting->update(['status' => 'diproses']);
            }

            // Reload data dengan filter tanggal hari ini
            $queues = Antrian::whereDate('waktu_datang', Carbon::today())
                ->orderBy('waktu_datang', 'asc')
                ->get();
        }

        return view('pages.dashboard', compact(
            'totalHarian',
            'totalBulanan',
            'totalPengunjung',
            'akunBaruBulanIni',
            'persenHarian',
            'persenBulanan',
            'persenPengunjung',
            'persenAkunBaru',
            'monthlySales',
            'salesChange',
            'queues'
        ));
    }

    public function updateStatus(Request $request, Antrian $queue)
    {
        $request->validate([
            'status' => 'required|in:selesai,dibatalkan',
        ]);

        // Update status antrian sekarang
        $queue->update(['status' => $request->status]);

        // Cari dan update antrian berikutnya yang statusnya 'menunggu' dan tanggal hari ini
        $nextQueue = Antrian::where('id', '>', $queue->id)
            ->where('status', 'menunggu')
            ->whereDate('waktu_datang', Carbon::today())
            ->orderBy('id')
            ->first();

        if ($nextQueue) {
            $nextQueue->update(['status' => 'diproses']);
        }

        return redirect()->route('home');
    }

    private function hitungPersen($lama, $baru)
    {
        if ($lama == 0) {
            return [
                'nilai' => 100,
                'naik' => true
            ];
        }

        $perubahan = (($baru - $lama) / $lama) * 100;
        return [
            'nilai' => number_format(abs($perubahan), 1),
            'naik' => $perubahan >= 0
        ];
    }
}
