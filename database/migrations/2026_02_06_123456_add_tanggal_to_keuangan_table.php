<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddTanggalToKeuanganTable extends Migration
{
    public function up()
    {
        Schema::table('keuangan', function (Blueprint $table) {
            if (!Schema::hasColumn('keuangan', 'tanggal')) {
                $table->timestamp('tanggal')->nullable()->after('kategori');
            }
        });
    }

    public function down()
    {
        Schema::table('keuangan', function (Blueprint $table) {
            if (Schema::hasColumn('keuangan', 'tanggal')) {
                $table->dropColumn('tanggal');
            }
        });
    }
}