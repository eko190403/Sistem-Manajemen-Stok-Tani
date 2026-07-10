<?php

namespace App\Exports;

use App\Models\Stok;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class StokExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $start;
    protected $end;
    protected $totalMasuk = 0;
    protected $totalKeluar = 0;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = Stok::orderBy('created_at', 'asc');
        
        if ($this->start && $this->end) {
            $query->whereBetween('created_at', [$this->start, $this->end]);
        }
        
        $data = $query->get();
        
        $this->totalMasuk = $data->where('jenis', 'pemasukan')->sum('jumlah');
        $this->totalKeluar = abs($data->where('jenis', 'pengeluaran')->sum('jumlah'));

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Nama Barang',
            'Pemasok',
            'Jenis',
            'Jumlah Asli',
            'Satuan Asli',
            'Potongan (%)',
            'Jumlah Bersih (Kg)',
            'Harga per Kg (Rp)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF3B82F6'], // Biru
                ],
            ],
        ];
    }

    public function map($stok): array
    {
        return [
            $stok->id,
            $stok->created_at->format('d-m-Y H:i'),
            $stok->nama_barang,
            $stok->nama_pemberi,
            ucfirst($stok->jenis),
            $stok->jumlah_asli ?? 0,
            strtoupper($stok->satuan_asli ?? 'KG'),
            $stok->potongan_persen ?? 0,
            abs($stok->jumlah),
            $stok->harga
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $totalRow = $lastRow + 2;

                $sheet->setCellValue("D{$totalRow}", 'TOTAL STOK MASUK:');
                $sheet->setCellValue("E{$totalRow}", number_format($event->getConcernable()->getTotalMasuk(), 2, ',', '.') . ' Kg');

                $sheet->setCellValue("F{$totalRow}", 'TOTAL STOK KELUAR:');
                $sheet->setCellValue("G{$totalRow}", number_format($event->getConcernable()->getTotalKeluar(), 2, ',', '.') . ' Kg');

                $sheet->setCellValue("H{$totalRow}", 'SISA STOK (RENTANG INI):');
                $sheet->setCellValue("I{$totalRow}", number_format($event->getConcernable()->getTotalMasuk() - $event->getConcernable()->getTotalKeluar(), 2, ',', '.') . ' Kg');

                $styleArray = [
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT],
                ];
                
                $sheet->getStyle("D{$totalRow}")->applyFromArray($styleArray);
                $sheet->getStyle("F{$totalRow}")->applyFromArray($styleArray);
                $sheet->getStyle("H{$totalRow}")->applyFromArray($styleArray);
                
                $sheet->getStyle("E{$totalRow}:I{$totalRow}")->getFont()->setBold(true);

                $sheet->getStyle("H{$totalRow}:I{$totalRow}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFDBEAFE'],
                    ]
                ]);
            },
        ];
    }

    public function getTotalMasuk() { return $this->totalMasuk; }
    public function getTotalKeluar() { return $this->totalKeluar; }
}
