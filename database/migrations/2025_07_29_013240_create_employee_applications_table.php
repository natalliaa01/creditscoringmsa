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
        Schema::create('employee_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_application_id')->constrained('credit_applications')->onDelete('cascade');
            $table->integer('usia')->nullable();
            $table->integer('masa_kerja')->nullable(); // Dalam tahun
            $table->string('golongan_jabatan')->nullable();
            $table->string('status_kepegawaian')->nullable(); // Tetap, Kontrak, dll.
            $table->decimal('gaji_bulanan', 15, 2)->nullable();
            $table->integer('jumlah_tanggungan')->nullable();
            $table->string('riwayat_kredit')->nullable(); // 'Ada'/'Tidak Ada' atau detail lainnya
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
        Schema::dropIfExists('employee_applications');
    }
};
