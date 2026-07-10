<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
                if (!Schema::hasColumn('blocks', 'is_valid')) {
                    $table->tinyInteger('is_valid')->default(1)->after('hash');
                }
        });
    }

    public function down(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            if (Schema::hasColumn('blocks', 'is_valid')) {
                $table->dropColumn('is_valid');
            }
        });
    }
};
