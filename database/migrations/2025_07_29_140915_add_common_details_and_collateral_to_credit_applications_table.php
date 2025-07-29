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
        Schema::table('credit_applications', function (Blueprint $table) {
            // Kolom NIK
            $table->string('nik')->nullable()->after('applicant_name'); // Tambahkan kolom NIK

            // Kolom umum untuk kedua tipe aplikasi (sudah ada)
            $table->date('tanggal_lahir')->nullable()->after('nik'); // Sesuaikan posisi after
            $table->string('nama_kantor_usaha')->nullable()->after('tanggal_lahir');

            // Kolom JSON untuk detail jaminan dinamis (sudah ada)
            $table->json('collateral_details')->nullable()->after('recommendation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_applications', function (Blueprint $table) {
            $table->dropColumn([
                'nik', // Hapus kolom NIK
                'tanggal_lahir',
                'nama_kantor_usaha',
                'collateral_details',
            ]);
        });
    }
};
