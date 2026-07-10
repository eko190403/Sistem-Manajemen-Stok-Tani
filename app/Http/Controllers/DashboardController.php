<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Block;
use App\Models\Keuangan;
use App\Models\User;
use App\Exports\LaporanExport;
use App\Services\BlockchainService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterBarang;
use App\Models\MasterPetani;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function load($page, Request $request)
    {
        switch ($page) {

            // ==============================
            //            OVERVIEW
            // ==============================
            case 'overview':
                $stoks = Stok::latest()->paginate(5);
                $blocks = Block::latest()->paginate(5);

                $totalPemasukan = Keuangan::where('jenis', 'pemasukan')->sum('total_uang');
                $totalPengeluaran = Keuangan::where('jenis', 'pengeluaran')->sum('total_uang');
                $saldoUang = $totalPemasukan - $totalPengeluaran;

                $totalMasukKg = Stok::where('jenis', 'pemasukan')->sum('jumlah');
                $totalKeluarKg = abs(Stok::where('jenis', 'pengeluaran')->sum('jumlah'));
                $saldoKg = Stok::sum('jumlah');

                $totalTransaksi = Keuangan::count();

                // Data hari ini
                $transaksiHariIni = Keuangan::whereDate('created_at', today())->count();
                $uangHariIni = Keuangan::whereDate('created_at', today())
                    ->where('jenis', 'pemasukan')
                    ->sum('total_uang');
                
                // Data bulan ini
                $transaksiBulanIni = Keuangan::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count();
                
                // Total anggota
                $totalAnggota = User::count();

                // Rekap saldo stok per pemasok (total masuk - total keluar)
                $rekapPemasok = Stok::select('nama_pemberi')
                    ->whereNotNull('nama_pemberi')
                    ->groupBy('nama_pemberi')
                    ->selectRaw('
                        nama_pemberi,
                        SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as total_masuk,
                        SUM(CASE WHEN jenis = "pengeluaran" THEN ABS(jumlah) ELSE 0 END) as total_keluar,
                        SUM(CASE WHEN jenis = "pemasukan" THEN 1 ELSE 0 END) as total_transaksi_masuk,
                        SUM(CASE WHEN jenis = "pengeluaran" THEN 1 ELSE 0 END) as total_transaksi_keluar
                    ')
                    ->get()
                    ->map(function($item) {
                        $item->saldo_stok = ($item->total_masuk ?? 0) - ($item->total_keluar ?? 0);
                        $item->total_transaksi = ($item->total_transaksi_masuk ?? 0) + ($item->total_transaksi_keluar ?? 0);
                        return $item;
                    })
                    ->sortByDesc('saldo_stok')
                    ->values();

                // Komposisi Stok per Barang (Doughnut Chart)
                $stokPerBarang = Stok::select('nama_barang')
                    ->selectRaw('SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE -jumlah END) as total_kg')
                    ->groupBy('nama_barang')
                    ->havingRaw('total_kg > 0')
                    ->orderByDesc('total_kg')
                    ->take(5)
                    ->get();

                // Stok Menipis (< 10kg)
                $stokMenipis = Stok::select('nama_barang')
                    ->selectRaw('SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE -jumlah END) as total_kg')
                    ->groupBy('nama_barang')
                    ->havingRaw('total_kg > 0 AND total_kg < 10')
                    ->orderBy('total_kg')
                    ->get();

                // Gunakan validasi yang sama dengan BlockchainValidationController
                $validation = BlockchainService::getValidationResults();

                return view('partials.dashboard_overview', compact(
                    'stoks',
                    'blocks',
                    'totalPemasukan',
                    'totalPengeluaran',
                    'saldoUang',
                    'totalMasukKg',
                    'totalKeluarKg',
                    'saldoKg',
                    'totalTransaksi',
                    'transaksiHariIni',
                    'uangHariIni',
                    'transaksiBulanIni',
                    'totalAnggota',
                    'rekapPemasok',
                    'stokPerBarang',
                    'stokMenipis'
                ))->with($validation);

            // ==============================
            //              STOK
            // ==============================
            case 'stok':
                $stoks = Stok::latest()->paginate(10);
                $totalPemasukan = Keuangan::where('jenis', 'pemasukan')->sum('total_uang');
                $totalPengeluaran = Keuangan::where('jenis', 'pengeluaran')->sum('total_uang');
                $saldoSekarang = $totalPemasukan - $totalPengeluaran;
                $stokSekarang = Stok::sum('jumlah');
                $totalStokMasuk = Stok::where('jenis', 'pemasukan')->sum('jumlah');
                $totalStokKeluar = abs(Stok::where('jenis', 'pengeluaran')->sum('jumlah'));
                // Rekap saldo stok per pemasok
                $rekapPemasok = Stok::select('nama_pemberi')
                    ->whereNotNull('nama_pemberi')
                    ->groupBy('nama_pemberi')
                    ->selectRaw('
                        nama_pemberi,
                        SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as total_masuk,
                        SUM(CASE WHEN jenis = "pengeluaran" THEN ABS(jumlah) ELSE 0 END) as total_keluar
                    ')
                    ->get()
                    ->mapWithKeys(function($item) {
                        $saldo = ($item->total_masuk ?? 0) - ($item->total_keluar ?? 0);
                        return [$item->nama_pemberi => $saldo];
                    });
                return view('partials.stok', compact('stoks', 'saldoSekarang', 'stokSekarang', 'totalStokMasuk', 'totalStokKeluar', 'rekapPemasok'));

            case 'stok_create':
                $barangs = MasterBarang::orderBy('nama_barang')->get();
                $petanis = MasterPetani::orderBy('nama_petani')->get();
                return view('partials.stok_create', compact('barangs', 'petanis'));

            case 'stok_edit':
                $id = $request->query('id');
                $stok = Stok::findOrFail($id);
                $barangs = MasterBarang::orderBy('nama_barang')->get();
                $petanis = MasterPetani::orderBy('nama_petani')->get();
                return view('partials.stok_edit', compact('stok', 'barangs', 'petanis'));

            // ==============================
            //            KEUANGAN
            // ==============================
            case 'keuangan':
                $filter = $request->get('filter', 'all');
                $year   = $request->get('year', date('Y'));
                $month  = $request->get('month', date('n'));
                $tanggal = $request->get('tanggal', date('Y-m-d'));

                $query = Keuangan::with(['stok' => function ($q) {
                    $q->whereNull('deleted_at');
                }]);

                if ($filter === 'tanggal') {
                    $query->whereDate('created_at', $tanggal);
                } elseif ($filter === 'bulan') {
                    $query->whereMonth('created_at', $month)
                          ->whereYear('created_at', $year);
                } elseif ($filter === 'tahun') {
                    $query->whereYear('created_at', $year);
                }

                $totalPemasukan = (clone $query)->where('jenis', 'pemasukan')->sum('total_uang');
                $totalPengeluaran = (clone $query)->where('jenis', 'pengeluaran')->sum('total_uang');
                $saldo = $totalPemasukan - $totalPengeluaran;

                $keuangans = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

                return view('partials.keuangan', compact(
                    'keuangans',
                    'totalPemasukan',
                    'totalPengeluaran',
                    'saldo'
                ));

            // ==============================
            //            BLOCKCHAIN
            // ==============================
            case 'blockchain':
                $blocks = Block::latest()->paginate(10);
                return view('partials.blockchain', compact('blocks'));

            case 'blockchain_validate':
                $allBlocks = Block::orderBy('id')->get();
                $isValid = true;
                $errorMessage = null;
                $totalBlocks = count($allBlocks);
                $validCount = 0;

                foreach ($allBlocks as $i => $block) {
                    $blockHashValid = ($block->hash === $block->calculateHash());
                    if ($blockHashValid) {
                        $validCount++;
                    }

                    if ($isValid) {
                        // 1. Validasi hash isi
                        if (!$blockHashValid) {
                            $isValid = false;
                            $errorMessage = "Hash blok ID {$block->id} tidak valid";
                        }
                        // 2. Genesis block
                        elseif ($i === 0) {
                            if ($block->previous_hash !== '0') {
                                $isValid = false;
                                $errorMessage = "Genesis block rusak";
                            }
                        } else {
                            $prev = $allBlocks[$i - 1];
                            if ($block->previous_hash !== $prev->hash) {
                                $isValid = false;
                                $errorMessage = "Previous hash blok ID {$block->id} tidak cocok";
                            }
                        }
                    }
                }

                $invalidCount = $totalBlocks - $validCount;

                // Pagination
                $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
                $perPage = 15;
                $currentPageItems = $allBlocks->slice(($currentPage - 1) * $perPage, $perPage)->values();
                $blocks = new \Illuminate\Pagination\LengthAwarePaginator(
                    $currentPageItems, 
                    $totalBlocks, 
                    $perPage, 
                    $currentPage, 
                    ['path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()]
                );

                return view('partials.blockchain_validate', compact('blocks', 'isValid', 'errorMessage', 'totalBlocks', 'validCount', 'invalidCount'));

            // ==============================
            //         MANAJEMEN USER
            // ==============================
            case 'users':
                if (Auth::user()->role !== 'admin') {
                    return response('<p>Akses ditolak</p>', 403);
                }
                $users = User::latest()->paginate(10);
                return view('partials.users', compact('users'));

            case 'users_create':
                if (Auth::user()->role !== 'admin') {
                    return response('<p>Akses ditolak</p>', 403);
                }
                return view('partials.users_create');

            case 'users_edit':
                if (Auth::user()->role !== 'admin') {
                    return response('<p>Akses ditolak</p>', 403);
                }
                $id = $request->query('id');
                $user = User::findOrFail($id);
                return view('partials.users_edit', compact('user'));

            // ==============================
            //         MASTER DATA
            // ==============================
            case 'master_barang':
                if (Auth::user()->role !== 'admin') {
                    return response('<p>Akses ditolak</p>', 403);
                }
                $barangs = MasterBarang::orderBy('nama_barang')->get();
                return view('partials.master_barang', compact('barangs'));

            case 'master_petani':
                if (Auth::user()->role !== 'admin') {
                    return response('<p>Akses ditolak</p>', 403);
                }
                $petanis = MasterPetani::orderBy('nama_petani')->get();
                return view('partials.master_petani', compact('petanis'));

            // ==============================
            //         LOG AKTIVITAS
            // ==============================
            case 'activity_logs':
                if (Auth::user()->role !== 'admin') {
                    return response('<p>Akses ditolak</p>', 403);
                }
                $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(15);
                return view('partials.activity_logs', compact('logs'));

            // ==============================
            //           LAPORAN EXPORT
            // ==============================
            case 'laporan_export':
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                return Excel::download(new LaporanExport($start, $end), 'laporan.xlsx');

            // ==============================
            //            DEFAULT
            // ==============================
            default:
                return response('<p>Halaman tidak ditemukan</p>', 404);
        }
    }
}
