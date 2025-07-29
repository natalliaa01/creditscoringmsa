<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_applications', function (Blueprint $table) {
            $table->string('jenis_penggunaan_kredit')->nullable()->after('riwayat_kredit');
            $table->string('jenis_jaminan')->nullable()->after('jenis_penggunaan_kredit');
            $table->string('sumber_dana_pengembalian')->nullable()->after('jenis_jaminan');
            $table->decimal('plafond_pengajuan', 15, 2)->nullable()->after('sumber_dana_pengembalian');
            $table->integer('jangka_waktu_kredit')->nullable()->after('plafond_pengajuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_applications', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_penggunaan_kredit',
                'jenis_jaminan',
                'sumber_dana_pengembalian',
                'plafond_pengajuan',
                'jangka_waktu_kredit',
            ]);
        });
    }
};