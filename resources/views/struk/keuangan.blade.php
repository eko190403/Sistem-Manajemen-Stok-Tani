<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Keuangan - #{{ $keuangan->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
        }
        .struk-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            border: 1px dashed #000;
            padding: 15px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .divider {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px 0;
            vertical-align: top;
        }
        .w-40 { width: 40%; }
        .w-60 { width: 60%; }
        
        @media print {
            body { padding: 0; }
            .struk-container { border: none; max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="struk-container">
        <div class="text-center">
            <h2 style="margin:0;">TOKO TANI BERKAH</h2>
            <p style="margin:5px 0;">Jl. Contoh Alamat No. 123</p>
            <p style="margin:5px 0;">Telp: 0812-3456-7890</p>
            <h3 style="margin:10px 0 5px 0;text-transform:uppercase;">BUKTI {{ $keuangan->kategori }}</h3>
        </div>
        
        <div class="divider"></div>
        
        <table>
            <tr>
                <td class="w-40">No. Trx</td>
                <td class="w-60">: #KEU-{{ str_pad($keuangan->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $keuangan->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @if($keuangan->stok)
            <tr>
                <td>Terkait Stok</td>
                <td>: #STK-{{ str_pad($keuangan->stok_id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            @endif
            <tr>
                <td>Jenis Trx</td>
                <td>: {{ strtoupper($keuangan->jenis) }}</td>
            </tr>
        </table>
        
        <div class="divider"></div>
        
        <table>
            <tr>
                <td class="font-bold pb-2" colspan="2">Detail Transaksi</td>
            </tr>
            <tr>
                <td colspan="2" style="padding-bottom:10px;">{{ $keuangan->keterangan }}</td>
            </tr>
            @if($keuangan->stok)
            <tr>
                <td class="w-40">Kuantitas Asli</td>
                <td class="w-60">: {{ number_format($keuangan->jumlah_asli, 2, ',', '.') }} {{ ucfirst($keuangan->stok->satuan_asli) }}</td>
            </tr>
            <tr>
                <td>Potongan</td>
                <td>: {{ $keuangan->potongan_persen }}%</td>
            </tr>
            <tr>
                <td>Kuantitas Bersih</td>
                <td>: {{ number_format($keuangan->jumlah_bersih, 2, ',', '.') }} Kg</td>
            </tr>
            <tr>
                <td>Harga/Kg</td>
                <td>: Rp {{ number_format($keuangan->harga, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>
        
        <div class="divider"></div>
        
        <table>
            <tr>
                <td class="w-40 font-bold" style="font-size: 16px;">TOTAL</td>
                <td class="w-60 font-bold text-right" style="font-size: 16px;">
                    Rp {{ number_format($keuangan->total_uang, 0, ',', '.') }}
                </td>
            </tr>
        </table>
        
        <div class="divider"></div>
        
        <div class="text-center" style="margin-top: 20px;">
            <p style="margin:5px 0;">Terima Kasih</p>
            <p style="margin:5px 0;">-- Sistem Manajemen Stok --</p>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
