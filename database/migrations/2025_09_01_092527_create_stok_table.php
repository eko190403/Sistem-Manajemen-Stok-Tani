<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stok', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_barang', 255);
            $table->integer('jumlah_asli')->nullable();
            $table->decimal('potongan_persen', 5, 2)->default(0.00);
            $table->decimal('jumlah', 12, 2);
            $table->string('satuan', 20);
            $table->string('satuan_asli', 50)->default('kg');
            $table->decimal('harga', 15, 2)->default(0.00);
            $table->enum('jenis', ['pemasukan', 'pengeluaran'])->default('pemasukan');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
