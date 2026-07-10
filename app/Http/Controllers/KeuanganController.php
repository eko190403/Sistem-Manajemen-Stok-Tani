<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KeuanganExport;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Services\ActivityLogService;

class KeuanganController extends Controller
{
    /**
     * Tambah Saldo dari stok
     */
    public function tambahSaldo(Request $request)
    {
        $validated = $request->validate([
            'jumlah_saldo' => 'required|numeric|min:0',
            'keterangan_saldo' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $keuangan = \App\Models\Keuangan::create([
                'stok_id' => null,
                'jumlah_asli' => 0,
                'potongan_persen' => 0,
                'jumlah_bersih' => 0,
                'harga' => 0,
                'total_uang' => $validated['jumlah_saldo'],
                'jenis' => 'pemasukan',
                'kategori' => 'saldo',
                'tanggal' => now(),
                'keterangan' => '[SALDO] ' . $validated['keterangan_saldo'],
            ]);

            // Catat ke blockchain
            \App\Services\BlockchainService::addBlock(null, 'create', [
                'keuangan_id' => $keuangan->id,
                'jumlah_saldo' => $validated['jumlah_saldo'],
                'keterangan_saldo' => $validated['keterangan_saldo'],
                'total_uang' => $keuangan->total_uang,
                'jenis' => $keuangan->jenis,
                'keterangan' => $keuangan->keterangan,
                'actor' => Auth::user()->name ?? 'system',
            ]);

            ActivityLogService::log('create', "Menambah Saldo Awal: Rp " . number_format($validated['jumlah_saldo'], 0, ',', '.'), 'Keuangan', $keuangan->id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan saldo',
                'error' => $e->getMessage()
            ], 500);
        }

        // Hitung saldo sekarang
        $totalPemasukan = \App\Models\Keuangan::whereIn('jenis', ['pemasukan', 'modal'])->sum('total_uang');
        $totalPengeluaran = \App\Models\Keuangan::where('jenis', 'pengeluaran')->sum('total_uang');
        $saldoSekarang = $totalPemasukan - $totalPengeluaran;

        return response()->json([
            'success' => true,
            'saldoSekarang' => $saldoSekarang,
        ]);
    }

    /**
     * Tambah Modal Usaha
     */
    public function tambahModal(Request $request)
    {
        $request->validate([
            'jumlah_modal' => 'required|numeric|min:0',
            'keterangan_modal' => 'required|string|max:255',
        ]);

        $keuangan = \App\Models\Keuangan::create([
            'stok_id' => null,
            'jumlah_asli' => 0,
            'potongan_persen' => 0,
            'jumlah_bersih' => 0,
            'harga' => 0,
            'total_uang' => $request->jumlah_modal,
            'jenis' => 'modal',
            'kategori' => 'modal',
            'tanggal' => now(),
            'keterangan' => '[MODAL] ' . $request->keterangan_modal,
        ]);

        // Catat ke blockchain
        \App\Services\BlockchainService::addBlock(null, 'modal', [
            'keuangan_id' => $keuangan->id,
            'jumlah_modal' => $request->jumlah_modal,
            'keterangan_modal' => $request->keterangan_modal,
            'actor' => Auth::user()->name ?? 'system',
        ]);

        ActivityLogService::log('create', "Menambah Modal Usaha: Rp " . number_format($request->jumlah_modal, 0, ',', '.'), 'Keuangan', $keuangan->id);

        // Jika request AJAX, balas JSON, jika tidak, redirect
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Modal usaha berhasil ditambahkan!'
            ]);
        }
        return redirect()->back()->with('success', 'Modal usaha berhasil ditambahkan!');
    }

    /**
     * Dashboard Keuangan
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $month  = $request->get('month', date('n'));
        $year   = $request->get('year', date('Y'));

        $query = DB::table('keuangan')
            ->leftJoin('stok', 'keuangan.stok_id', '=', 'stok.id')
            ->select(
                'keuangan.id',
                DB::raw('COALESCE(stok.nama_barang, "DELETED") as nama_barang'),
                'keuangan.jumlah_asli',
                'keuangan.potongan_persen',
                'keuangan.jumlah_bersih',
                'keuangan.harga',
                'keuangan.total_uang',
                'keuangan.jenis',
                'keuangan.kategori',
                'keuangan.tanggal',
                'keuangan.keterangan',
                'keuangan.created_at'
            );

        if ($filter === 'tanggal') {
            $tanggal = $request->get('tanggal', date('Y-m-d'));
            $query->whereDate('keuangan.created_at', $tanggal);
        } elseif ($filter === 'bulan') {
            $query->whereMonth('keuangan.created_at', $month)
                  ->whereYear('keuangan.created_at', $year);
        } elseif ($filter === 'tahun') {
            $query->whereYear('keuangan.created_at', $year);
        }

        $keuangans = $query->orderBy('keuangan.created_at', 'desc')->get();

        $totalPemasukan   = $keuangans->whereIn('jenis', ['pemasukan', 'modal'])->sum('total_uang');
        $totalPengeluaran = $keuangans->where('jenis', 'pengeluaran')->sum('total_uang');
        $saldoUang        = $totalPemasukan - $totalPengeluaran;

        $labelNamaBarang = $keuangans->pluck('nama_barang')->unique();
        $dataPemasukan   = $keuangans->where('jenis', 'pemasukan')->groupBy('nama_barang')->map->sum('total_uang');
        $dataPengeluaran = $keuangans->where('jenis', 'pengeluaran')->groupBy('nama_barang')->map->sum('total_uang');

        return view('keuangan.index', compact(
            'keuangans',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoUang',
            'labelNamaBarang',
            'dataPemasukan',
            'dataPengeluaran'
        ));
    }

    /**
     * API data tabel keuangan (pagination)
     */
    public function getData(Request $request)
    {
        $year = $request->get('year');

        $query = DB::table('keuangan')
            ->leftJoin('stok', 'keuangan.stok_id', '=', 'stok.id')
            ->select(
                'keuangan.id',
                DB::raw('COALESCE(stok.nama_barang, "DELETED") as nama_barang'),
                'keuangan.total_uang',
                'keuangan.jenis',
                'keuangan.kategori',
                'keuangan.keterangan',
                'keuangan.created_at'
            );

        if ($year) {
            $query->whereYear('keuangan.created_at', $year);
        }

        $data = $query->orderBy('keuangan.created_at', 'desc')->get();

        $totalPemasukan = $data->whereIn('jenis', ['pemasukan', 'modal'])->sum('total_uang');
        $totalPengeluaran = $data->where('jenis', 'pengeluaran')->sum('total_uang');

        return response()->json([
            'data' => $data,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $totalPemasukan - $totalPengeluaran
        ]);
    }

    /**
     * Cetak Struk Keuangan
     */
    public function cetakStruk($id)
    {
        $keuangan = \App\Models\Keuangan::with('stok')->findOrFail($id);
        return view('struk.keuangan', compact('keuangan'));
    }

    /**
     * Grafik Bulanan
     */
    public function getGrafikBulanan()
    {
        $data = DB::table('keuangan')
            ->selectRaw("
                DATE_FORMAT(created_at, '%Y-%m') as bulan,
                SUM(CASE WHEN jenis = 'pemasukan' THEN total_uang ELSE 0 END) as pemasukan,
                SUM(CASE WHEN jenis = 'pengeluaran' THEN total_uang ELSE 0 END) as pengeluaran
            ")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return response()->json([
            'labels'      => $data->pluck('bulan'),
            'pemasukan'   => $data->pluck('pemasukan'),
            'pengeluaran' => $data->pluck('pengeluaran'),
        ]);
    }

    /**
     * Export Excel dengan filter periode
     */
    public function exportExcel(Request $request)
    {
        $filterType = $request->get('filterType', 'semua');
        $start = null;
        $end = null;

        if ($filterType === 'bulan') {
            $month = $request->get('month', date('n'));
            $year = $request->get('year', date('Y'));
            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end = Carbon::create($year, $month, 1)->endOfMonth();
        } elseif ($filterType === 'tahun') {
            $year = $request->get('year', date('Y'));
            $start = Carbon::create($year, 1, 1)->startOfYear();
            $end = Carbon::create($year, 12, 31)->endOfYear();
        } elseif ($filterType === 'rentang') {
            $start = $request->startDate ? Carbon::parse($request->startDate)->startOfDay() : now()->startOfMonth();
            $end = $request->endDate ? Carbon::parse($request->endDate)->endOfDay() : now()->endOfMonth();
        }

        // Menggunakan LaporanExport agar data yang diunduh adalah detail riwayat lengkap, bukan rekap.
        return Excel::download(
            new \App\Exports\LaporanExport($start, $end),
            'laporan_keuangan.xlsx'
        );
    }
}
