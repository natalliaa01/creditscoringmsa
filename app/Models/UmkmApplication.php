<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'credit_application_id',
        'omzet_usaha',
        'lama_usaha',
        'sektor_ekonomi',
        'lokasi_usaha',
        'riwayat_pinjaman',
        'jenis_penggunaan_kredit',
        'jenis_jaminan',
        'sumber_dana_pengembalian',
        'plafond_pengajuan',
        'jangka_waktu_kredit',
    ];

    /**
     * Get the credit application that owns the UMKM application.
     */
    public function creditApplication()
    {
        return $this->belongsTo(CreditApplication::class);
    }
}
