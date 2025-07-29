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
        Schema::create('credit_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang membuat aplikasi
            $table->string('applicant_name'); // Nama pemohon kredit
            $table->string('application_type'); // 'UMKM/Pengusaha' atau 'Pegawai'
            $table->string('status')->default('Pending'); // Status aplikasi (Pending, Approved, Rejected, etc.)
            $table->json('scoring_result')->nullable(); // Hasil scoring dari Python (JSON)
            $table->json('recommendation')->nullable(); // Rekomendasi dari Python (JSON)
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
        Schema::dropIfExists('credit_applications');
    }
};