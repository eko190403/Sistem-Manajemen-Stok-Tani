<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';

    protected $fillable = [
        'nama_barang',
        'nama_pemberi',
        'jumlah',
        'jumlah_asli',
        'satuan',
        'satuan_asli',
        'harga',
        'jenis',
        'potongan_persen',
    ];

    public function keuangan()
    {
        return $this->hasOne(Keuangan::class);
    }
}
