<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class KeuanganExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize, WithStyles
{
    protected $keuangans;
    protected $filter;
    protected $month;
    protected $year;

    public function __construct($filter = 'all', $month = null, $year = null)
    {
        $this->filter = $filter;
        $this->month  = $month ?? Carbon::now()->month;
        $this->year   = $year ?? Carbon::now()->year;

        $query = DB::table('keuangan')
            ->join('stok', 'keuangan.stok_id', '=', 'stok.id')
            ->select(
                'stok.nama_barang',
                'stok.satuan',
                DB::raw('SUM(CASE WHEN keuangan.jenis = "pemasukan" THEN keuangan.jumlah_bersih ELSE 0 END) as total_masuk'),
                DB::raw('SUM(CASE WHEN keuangan.jenis = "pengeluaran" THEN keuangan.jumlah_bersih ELSE 0 END) as total_keluar'),
                DB::raw('SUM(CASE WHEN keuangan.jenis = "pemasukan" THEN keuangan.total_uang ELSE 0 END) as total_uang_masuk'),
                DB::raw('SUM(CASE WHEN keuangan.jenis = "pengeluaran" THEN keuangan.total_uang ELSE 0 END) as total_uang_keluar')
            );

        // Filter periode
        if ($this->filter === 'minggu') {
            $query->whereBetween('keuangan.created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }

        if ($this->filter === 'bulan') {
            $query->whereMonth('keuangan.created_at', $this->month)
                  ->whereYear('keuangan.created_at', $this->year);
        }

        if ($this->filter === 'tahun') {
            $query->whereYear('keuangan.created_at', $this->year);
        }

        $this->keuangans = $query
            ->groupBy('keuangan.stok_id', 'stok.nama_barang', 'stok.satuan')
            ->get();
    }

    public function collection()
    {
        return $this->keuangans;
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Satuan',
            'Total Masuk (Kg)',
            'Total Keluar (Kg)',
            'Saldo (Kg)',
            'Uang Masuk (Rp)',
            'Uang Keluar (Rp)',
            'Saldo Uang (Rp)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style header row
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF10B981'], // Hijau untuk keuangan
                ],
            ],
        ];
    }

    public function map($row): array
    {
        return [
            $row->nama_barang,
            $row->satuan,
            $row->total_masuk,
            $row->total_keluar,
            $row->total_masuk - $row->total_keluar,
            $row->total_uang_masuk,
            $row->total_uang_keluar,
            $row->total_uang_masuk - $row->total_uang_keluar
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow() + 1;

                $sheet->setCellValue("A{$lastRow}", 'TOTAL');
                $sheet->setCellValue("C{$lastRow}", "=SUM(C2:C".($lastRow-1).")");
                $sheet->setCellValue("D{$lastRow}", "=SUM(D2:D".($lastRow-1).")");
                $sheet->setCellValue("E{$lastRow}", "=SUM(E2:E".($lastRow-1).")");
                $sheet->setCellValue("F{$lastRow}", "=SUM(F2:F".($lastRow-1).")");
                $sheet->setCellValue("G{$lastRow}", "=SUM(G2:G".($lastRow-1).")");
                $sheet->setCellValue("H{$lastRow}", "=SUM(H2:H".($lastRow-1).")");
                $sheet->getStyle("A{$lastRow}:H{$lastRow}")->getFont()->setBold(true);
            },
        ];
    }
}