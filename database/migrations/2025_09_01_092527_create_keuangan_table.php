<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stok_id')->unsigned()->nullable();
            $table->enum('jenis', ['pemasukan', 'pengeluaran', 'modal']);
            $table->decimal('jumlah_asli', 12, 2)->comment('Jumlah sebelum potongan (kg)');
            $table->decimal('potongan_persen', 5, 2)->default(0.00)->comment('Potongan kualitas (%)');
            $table->decimal('jumlah_bersih', 12, 2)->comment('Jumlah setelah potongan (kg)');
            $table->decimal('harga', 12, 2)->comment('Harga per kg');
            $table->decimal('total_uang', 14, 2)->comment('jumlah_bersih × harga');
            $table->string('keterangan', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->index('stok_id', 'idx_stok');
            $table->index('jenis', 'idx_jenis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
