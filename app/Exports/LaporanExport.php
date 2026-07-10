<?php

namespace App\Exports;

use App\Models\Keuangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $start;
    protected $end;
    protected $totalPemasukan = 0;
    protected $totalPengeluaran = 0;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Ambil data sesuai range tanggal
     */
    public function collection()
    {
        $query = Keuangan::orderBy('created_at', 'asc');
        
        if ($this->start && $this->end) {
            $query->whereBetween('created_at', [$this->start, $this->end]);
        }
        
        $data = $query->get();
        
        $this->totalPemasukan = $data->whereIn('jenis', ['pemasukan', 'modal'])->sum('total_uang');
        $this->totalPengeluaran = $data->where('jenis', 'pengeluaran')->sum('total_uang');

        return $data;
    }

    /**
     * Header Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Jenis',
            'Jumlah Asli (Kg)',
            'Potongan (%)',
            'Jumlah Bersih (Kg)',
            'Harga per Kg (Rp)',
            'Total Uang (Rp)',
            'Keterangan',
            'Tanggal',
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
                    'startColor' => ['argb' => 'FF3B82F6'],
                ],
            ],
        ];
    }

    /**
     * Mapping data agar sesuai kolom Excel
     */
    public function map($keuangan): array
    {
        return [
            $keuangan->id,
            ucfirst($keuangan->jenis),
            $keuangan->jumlah_asli,
            $keuangan->potongan_persen,
            $keuangan->jumlah_bersih,
            $keuangan->harga,
            $keuangan->total_uang,
            $keuangan->keterangan,
            $keuangan->created_at->format('d-m-Y H:i'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $totalRow = $lastRow + 2; // Beri jarak 1 baris

                // Label dan Rumus Pemasukan (Kolom D dan E)
                $sheet->setCellValue("D{$totalRow}", 'TOTAL PEMASUKAN:');
                $sheet->setCellValue("E{$totalRow}", $event->getConcernable()->getTotalPemasukan());

                // Label dan Rumus Pengeluaran (Kolom F dan G)
                $sheet->setCellValue("F{$totalRow}", 'TOTAL PENGELUARAN:');
                $sheet->setCellValue("G{$totalRow}", $event->getConcernable()->getTotalPengeluaran());

                // Label dan Rumus Saldo (Kolom H dan I)
                $sheet->setCellValue("H{$totalRow}", 'SALDO AKHIR:');
                $sheet->setCellValue("I{$totalRow}", $event->getConcernable()->getTotalPemasukan() - $event->getConcernable()->getTotalPengeluaran());

                // Style untuk baris total (Rata Kanan & Bold)
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    ],
                ];
                
                // Terapkan style rata kanan ke label
                $sheet->getStyle("D{$totalRow}")->applyFromArray($styleArray);
                $sheet->getStyle("F{$totalRow}")->applyFromArray($styleArray);
                $sheet->getStyle("H{$totalRow}")->applyFromArray($styleArray);
                
                // Terapkan bold dan rata kiri/default ke angka hasil rumusnya
                $sheet->getStyle("E{$totalRow}")->getFont()->setBold(true);
                $sheet->getStyle("G{$totalRow}")->getFont()->setBold(true);
                $sheet->getStyle("I{$totalRow}")->getFont()->setBold(true);

                // Format angka sebagai Accounting/Rupiah standar jika diperlukan
                $sheet->getStyle("E{$totalRow}:I{$totalRow}")->getNumberFormat()->setFormatCode('#,##0');

                // Beri warna background khusus pada sel Saldo Akhir agar menonjol
                $sheet->getStyle("H{$totalRow}:I{$totalRow}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFDBEAFE'], // Biru muda
                    ]
                ]);
            },
        ];
    }

    public function getTotalPemasukan()
    {
        return $this->totalPemasukan;
    }

    public function getTotalPengeluaran()
    {
        return $this->totalPengeluaran;
    }
}