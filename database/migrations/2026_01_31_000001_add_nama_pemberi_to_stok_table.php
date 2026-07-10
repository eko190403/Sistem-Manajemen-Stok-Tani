<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('stok', function (Blueprint $table) {
            if (!Schema::hasColumn('stok', 'nama_pemberi')) {
                $table->string('nama_pemberi', 100)->nullable()->after('nama_barang');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stok', function (Blueprint $table) {
            if (Schema::hasColumn('stok', 'nama_pemberi')) {
                $table->dropColumn('nama_pemberi');
            }
        });
    }
};
