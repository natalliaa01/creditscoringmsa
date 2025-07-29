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
        Schema::create('umkm_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_application_id')->constrained('credit_applications')->onDelete('cascade');
            $table->decimal('omzet_usaha', 15, 2)->nullable();
            $table->integer('lama_usaha')->nullable(); // Dalam bulan atau tahun
            $table->string('sektor_ekonomi')->nullable();
            $table->string('lokasi_usaha')->nullable();
            $table->string('riwayat_pinjaman')->nullable(); // 'Ada'/'Tidak Ada' atau detail lainnya
            $table->string('jenis_penggunaan_kredit')->nullable();
            $table->string('jenis_jaminan')->nullable();
            $table->string('sumber_dana_pengembalian')->nullable();
            $table->decimal('plafond_pengajuan', 15, 2)->nullable();
            $table->integer('jangka_waktu_kredit')->nullable(); // Dalam bulan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('umkm_applications');
    }
};