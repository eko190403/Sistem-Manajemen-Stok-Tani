<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriToKeuanganTable extends Migration
{
    public function up()
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->enum('kategori', ['stok', 'modal', 'operasional'])
                  ->after('stok_id')
                  ->default('stok'); // default supaya data lama aman
            $table->index('kategori', 'idx_kategori');
        });
    }

    public function down()
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
}
