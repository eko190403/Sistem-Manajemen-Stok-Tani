<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'keuangan';

    protected $fillable = [
        'stok_id',
        'jenis',
        'kategori',
        'tanggal',
        'jumlah_asli',
        'potongan_persen',
        'jumlah_bersih',
        'harga',
        'total_uang',
        'keterangan'
    ];

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }
}

