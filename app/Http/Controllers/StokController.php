<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Stok;
use App\Models\Keuangan;
use App\Services\BlockchainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogService;

class StokController extends Controller
{
    /**
     * ======================
     * INDEX
     * ======================
     */
    public function index()
    {
        $stoks = Stok::with('keuangan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung saldo sekarang
        $totalPemasukan = Keuangan::whereIn('jenis', ['pemasukan', 'modal'])->sum('total_uang');
        $totalPengeluaran = Keuangan::where('jenis', 'pengeluaran')->sum('total_uang');
        $saldoSekarang = $totalPemasukan - $totalPengeluaran;

        // Hitung stok sekarang (total semua barang)Z
        $stokSekarang = Stok::sum('jumlah');


        // Rekap saldo stok pemasok (total masuk - total keluar) dengan struktur collection of object (seperti dashboard)
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

        return view('stok.index', compact('stoks', 'saldoSekarang', 'stokSekarang', 'rekapPemasok'));
    }

    /**
     * ======================
     * STORE
     * ======================
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama_barang'     => 'required|string|max:255',
            'nama_pemberi'    => 'required|string|max:100',
            'jumlah_asli'     => 'required|numeric|min:0.01',
            'potongan_persen' => 'nullable|numeric|min:0|max:100',
            'satuan'          => 'required|in:kg,ton,kuintal',
            'harga'           => 'required|numeric|min:0',
            'jenis'           => 'required|in:pemasukan,pengeluaran',
        ]);

        $stok = null;
        $keuangan = null;
        DB::transaction(function () use ($validated, &$stok, &$keuangan) {
            // ...existing code untuk simpan stok, keuangan, blockchain...
            $jumlahAsli = $validated['jumlah_asli'];
            $potongan   = $validated['potongan_persen'] ?? 0;
            $bersih     = $jumlahAsli - ($jumlahAsli * $potongan / 100);
            $jumlahKg = match ($validated['satuan']) {
                'ton'     => $bersih * 1000,
                'kuintal' => $bersih * 100,
                default   => $bersih,
            };
            if ($validated['jenis'] === 'pengeluaran') {
                $jumlahKg *= -1;
            }
            $stok = Stok::create([
                'nama_barang'  => $validated['nama_barang'],
                'nama_pemberi' => $validated['nama_pemberi'],
                'jumlah'       => $jumlahKg,
                'satuan'       => 'kg',
                'satuan_asli'  => $validated['satuan'],
                'harga'        => $validated['harga'],
                'jenis'        => $validated['jenis'],
            ]);
            $jumlahBersih = abs($jumlahKg);
            $totalUang    = $jumlahBersih * $validated['harga'];
            $keuangan = Keuangan::create([
                'stok_id'         => $stok->id,
                'jenis'           => $validated['jenis'],
                'jumlah_asli'     => $jumlahAsli,
                'potongan_persen' => $potongan,
                'jumlah_bersih'   => $jumlahBersih,
                'harga'           => $validated['harga'],
                'total_uang'      => $totalUang,
                'keterangan'      => ucfirst($validated['jenis']) . ' ' . $stok->nama_barang,
            ]);
            $this->addBlock($stok->id, 'create', [
                'keuangan_id'  => $keuangan->id,
                'nama_barang'  => $stok->nama_barang,
                'nama_pemasok' => $stok->nama_pemberi,
                'jumlah'       => $jumlahBersih,
                'satuan'       => 'Kg',
                'jenis'        => $validated['jenis'],
                'harga'        => $validated['harga'],
                'total_uang'   => $totalUang,
                'actor'        => auth()->user()->name ?? 'system',
            ]);

            ActivityLogService::log('create', "Menambah transaksi stok: {$stok->nama_barang} ({$jumlahKg} kg)", 'Stok', $stok->id);
        });
        return response()->json([
            'success' => true,
            'message' => 'Transaksi stok berhasil dicatat',
            'stok' => $stok,
            'keuangan' => $keuangan
        ]);
    }

    /**
     * ======================
     * BLOCKCHAIN CORE
     * ======================
     */
    protected function addBlock($stokId, $action, $data)
    {
        BlockchainService::addBlock($stokId, $action, $data);
    }

    /**
     * ======================
     * CETAK STRUK
     * ======================
     */
    public function cetakStruk($id)
    {
        $stok = Stok::with('keuangan')->findOrFail($id);
        return view('struk.stok', compact('stok'));
    }

    /**
     * ======================
     * API: GRAFIK STOK
     * ======================
     */
    public function grafik()
    {
        $data = DB::table('stok')
            ->selectRaw("
                DATE_FORMAT(created_at, '%Y-%m') as bulan,
                SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) as masuk,
                SUM(CASE WHEN jenis = 'pengeluaran' THEN ABS(jumlah) ELSE 0 END) as keluar
            ")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return response()->json([
            'labels' => $data->pluck('bulan'),
            'masuk'  => $data->pluck('masuk'),
            'keluar' => $data->pluck('keluar'),
        ]);
    }
}
