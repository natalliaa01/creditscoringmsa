<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'credit_application_id',
        'usia',
        'masa_kerja',
        'golongan_jabatan',
        'status_kepegawaian',
        'gaji_bulanan',
        'jumlah_tanggungan',
        'riwayat_kredit',
    ];

    /**
     * Get the credit application that owns the employee application.
     */
    public function creditApplication()
    {
        return $this->belongsTo(CreditApplication::class);
    }
}