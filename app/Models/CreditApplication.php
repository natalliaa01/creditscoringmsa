<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'applicant_name',
        'nik', // Tambahkan NIK
        'tanggal_lahir', // Tambahkan tanggal_lahir
        'nama_kantor_usaha', // Tambahkan nama_kantor_usaha
        'application_type',
        'status',
        'scoring_result',
        'recommendation',
        'collateral_details', // Tambahkan collateral_details
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'scoring_result' => 'array', // Cast sebagai array/JSON
        'recommendation' => 'array', // Cast sebagai array/JSON
        'collateral_details' => 'array', // Cast sebagai array/JSON untuk detail jaminan
    ];

    /**
     * Get the user that owns the credit application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the UMKM application associated with the credit application.
     */
    public function umkmApplication()
    {
        return $this->hasOne(UmkmApplication::class);
    }

    /**
     * Get the employee application associated with the credit application.
     */
    public function employeeApplication()
    {
        return $this->hasOne(EmployeeApplication::class);
    }
}