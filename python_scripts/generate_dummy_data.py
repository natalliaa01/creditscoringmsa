# python_scripts/generate_dummy_data.py
import pandas as pd
import numpy as np
print(pd.__version__)
print(np.__version__)
import random

def generate_dummy_data(num_samples=200): # Mengurangi jumlah sampel untuk awal
    """
    Menghasilkan data dummy untuk Kredit UMKM/Pengusaha dan Pegawai.
    Mencakup berbagai kemungkinan untuk keputusan kredit.
    """
    data = []

    for i in range(num_samples):
        app_type = random.choice(['UMKM/Pengusaha', 'Pegawai'])
        row = {'application_type': app_type}

        # Fitur Umum (jika ada) - untuk saat ini fokus pada yang spesifik per tipe
        # row['applicant_name'] = f"Applicant {i+1}" # Contoh jika ada nama pemohon

        if app_type == 'UMKM/Pengusaha':
            row['omzet_usaha'] = round(random.uniform(1_000_000, 200_000_000), 2)
            row['lama_usaha'] = random.randint(0, 10) # Bisa 0 tahun untuk yang sangat baru
            row['sektor_ekonomi'] = random.choice(['Perdagangan', 'Jasa', 'Manufaktur', 'Pertanian', 'IT', 'Kuliner', 'Transportasi', 'Lainnya'])
            row['lokasi_usaha'] = random.choice(['Pusat Kota', 'Pinggir Kota', 'Pedesaan', 'Online'])
            row['riwayat_pinjaman'] = random.choice(['Ada', 'Tidak Ada', 'Pernah Macet']) # Menambah 'Pernah Macet'
            row['jenis_penggunaan_kredit'] = random.choice(['Modal Kerja', 'Investasi', 'Pembelian Aset', 'Renovasi', 'Konsumsi'])
            row['jenis_jaminan'] = random.choice(['Tanah/Bangunan', 'Kendaraan', 'Persediaan', 'Piutang', 'Tidak Ada'])
            row['sumber_dana_pengembalian'] = random.choice(['Usaha Sendiri', 'Penjualan Aset', 'Tambahan Modal', 'Lain-lain'])
            row['plafond_pengajuan'] = round(random.uniform(5_000_000, 500_000_000), 2)
            row['jangka_waktu_kredit'] = random.randint(3, 72) # Dalam bulan

            # Logika dummy untuk keputusan kredit UMKM (lebih bervariasi)
            # Kondisi untuk 'Layak'
            if (row['omzet_usaha'] > 50_000_000 and row['lama_usaha'] >= 3 and
                row['riwayat_pinjaman'] == 'Tidak Ada' and row['plafond_pengajuan'] <= (row['omzet_usaha'] * 12 * 0.5)):
                row['keputusan_kredit'] = 'Layak'
            # Kondisi untuk 'Tidak Layak'
            elif (row['omzet_usaha'] < 5_000_000 or row['lama_usaha'] < 1 or
                  row['riwayat_pinjaman'] == 'Pernah Macet' or row['plafond_pengajuan'] > (row['omzet_usaha'] * 12 * 1.5)):
                row['keputusan_kredit'] = 'Tidak Layak'
            # Kondisi 'Pertimbangkan' atau random untuk kasus di antara
            else:
                row['keputusan_kredit'] = random.choice(['Layak', 'Tidak Layak', 'Pertimbangkan'])

            # Set kolom pegawai ke NaN
            row.update({
                'usia': np.nan, 'masa_kerja': np.nan, 'golongan_jabatan': np.nan,
                'status_kepegawaian': np.nan, 'gaji_bulanan': np.nan, 'jumlah_tanggungan': np.nan,
                'riwayat_kredit': np.nan
            })

        else: # Pegawai
            row['usia'] = random.randint(20, 65)
            row['masa_kerja'] = random.randint(0, 40)
            row['golongan_jabatan'] = random.choice(['Staf Pelaksana', 'Staf Senior', 'Supervisor', 'Manajer', 'Kepala Bagian', 'Direktur'])
            row['status_kepegawaian'] = random.choice(['Tetap', 'Kontrak', 'Outsource'])
            row['gaji_bulanan'] = round(random.uniform(2_500_000, 50_000_000), 2)
            row['jumlah_tanggungan'] = random.randint(0, 7)
            row['riwayat_kredit'] = random.choice(['Ada', 'Tidak Ada', 'Pernah Macet'])

            # Logika dummy untuk keputusan kredit Pegawai (lebih bervariasi)
            # Kondisi untuk 'Layak'
            if (row['gaji_bulanan'] > 10_000_000 and row['masa_kerja'] >= 3 and
                row['status_kepegawaian'] == 'Tetap' and row['riwayat_kredit'] == 'Tidak Ada' and
                row['jumlah_tanggungan'] <= 3):
                row['keputusan_kredit'] = 'Layak'
            # Kondisi untuk 'Tidak Layak'
            elif (row['gaji_bulanan'] < 4_000_000 or row['masa_kerja'] < 1 or
                  row['riwayat_kredit'] == 'Pernah Macet' or row['jumlah_tanggungan'] > 5):
                row['keputusan_kredit'] = 'Tidak Layak'
            # Kondisi 'Pertimbangkan' atau random untuk kasus di antara
            else:
                row['keputusan_kredit'] = random.choice(['Layak', 'Tidak Layak', 'Pertimbangkan'])

            # Set kolom UMKM ke NaN
            row.update({
                'omzet_usaha': np.nan, 'lama_usaha': np.nan, 'sektor_ekonomi': np.nan,
                'lokasi_usaha': np.nan, 'riwayat_pinjaman': np.nan, 'jenis_penggunaan_kredit': np.nan,
                'jenis_jaminan': np.nan, 'sumber_dana_pengembalian': np.nan,
                'plafond_pengajuan': np.nan, 'jangka_waktu_kredit': np.nan
            })

        data.append(row)

    df = pd.DataFrame(data)
    return df

if __name__ == '__main__':
    num_samples = 200 # Anda bisa mengubah jumlah sampel sesuai kebutuhan
    dummy_df = generate_dummy_data(num_samples)
    output_path = 'python_scripts/bpr_dummy_data.csv' # Nama file CSV dummy
    dummy_df.to_csv(output_path, index=False)
    print(f"Generated {num_samples} dummy data samples to {output_path}")

