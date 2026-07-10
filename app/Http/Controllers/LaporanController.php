<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Keuangan;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter tanggal
        $start = $request->startDate ? Carbon::parse($request->startDate) : now()->startOfMonth();
        $end = $request->endDate ? Carbon::parse($request->endDate) : now()->endOfMonth();

        // Transaksi keuangan dalam periode
        $transaksi = Keuangan::whereBetween('created_at', [$start, $end])
                        ->with('stok')
                        ->get();

        // Ringkasan keuangan
        $totalPemasukan = $transaksi->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Ringkasan stok
        $totalMasukKg = Stok::where('jenis', 'pemasukan')->sum('jumlah');
        $totalKeluarKg = Stok::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoKg = $totalMasukKg - $totalKeluarKg;

        // Data untuk chart
        $chartLabels = $transaksi->groupBy(function($d) {
            return $d->created_at->format('d-m'); 
        })->keys();

        $chartPemasukan = $transaksi->groupBy(function($d) {
            return $d->created_at->format('d-m'); 
        })->map(function($d) {
            return $d->where('jenis','pemasukan')->sum('jumlah');
        });

        $chartPengeluaran = $transaksi->groupBy(function($d) {
            return $d->created_at->format('d-m'); 
        })->map(function($d) {
            return $d->where('jenis','pengeluaran')->sum('jumlah');
        });

        return view('laporan.index', compact(
            'transaksi','totalPemasukan','totalPengeluaran','saldo',
            'totalMasukKg','totalKeluarKg','saldoKg',
            'chartLabels','chartPemasukan','chartPengeluaran'
        ));
    }

    // Export Excel
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

        return Excel::download(new \App\Exports\StokExport($start, $end), 'laporan_stok.xlsx');
    }
}
