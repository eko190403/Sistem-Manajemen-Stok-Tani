<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('stok', function (Blueprint $table) {
            if (!Schema::hasColumn('stok', 'jenis')) {
                $table->enum('jenis', ['pemasukan', 'pengeluaran'])->default('pemasukan')->after('satuan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stok', function (Blueprint $table) {
            if (Schema::hasColumn('stok', 'jenis')) {
                $table->dropColumn('jenis');
            }
        });
    }
};
