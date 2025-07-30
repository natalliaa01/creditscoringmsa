import pandas as pd
import numpy as np
import random
from faker import Faker
import json # <--- TAMBAHKAN BARIS INI

# Inisialisasi Faker untuk nama dan alamat
fake = Faker('id_ID') # Menggunakan locale Indonesia

def generate_dummy_data(num_records=200):
    data = []

    # Definisi kategori yang lebih beragam
    # Untuk Pegawai
    golongan_jabatan_pegawai = ['Staf Pelaksana', 'Administrasi', 'Staf Senior', 'Supervisor', 'Manajer', 'Kepala Bagian', 'Direktur']
    status_kepegawaian = ['Tetap', 'Kontrak', 'Outsource']
    riwayat_kredit = ['Tidak Ada', 'Ada', 'Pernah Macet'] # Perhatikan 'Pernah Macet' sudah dikoreksi
    jenis_penggunaan_kredit_pegawai = ['Konsumsi', 'Pendidikan', 'Renovasi Rumah', 'Pembelian Kendaraan', 'Urusan Pribadi', 'Lain-lain'] # Tambahan untuk Pegawai
    sumber_dana_pengembalian_pegawai = ['Gaji', 'Bonus', 'Pendapatan Lain', 'Lain-lain'] # Tambahan untuk Pegawai

    # Untuk UMKM/Pengusaha
    sektor_ekonomi = ['Kuliner', 'Kerajinan', 'Perdagangan', 'Jasa', 'IT', 'Pertanian', 'Transportasi', 'Manufaktur', 'Lainnya']
    lokasi_usaha_umkm = ['Pusat Kota', 'Pinggir Kota', 'Pedesaan', 'Online', 'Yogyakarta Kota', 'Sleman', 'Bantul'] # Tambahan lokasi spesifik
    riwayat_pinjaman_umkm = ['Ada', 'Tidak Ada', 'Pernah Macet']
    jenis_penggunaan_kredit_umkm = ['Modal Kerja', 'Investasi', 'Pembelian Aset', 'Renovasi', 'Konsumsi']
    jenis_jaminan_umkm = ['Tanah/Bangunan', 'Kendaraan', 'Persediaan', 'Piutang', 'Tidak Ada', 'Deposito', 'Emas'] # Tambahan jaminan
    sumber_dana_pengembalian_umkm = ['Usaha Sendiri', 'Penjualan Aset', 'Tambahan Modal', 'Lain-lain']

    # Lokasi Jaminan (baru)
    lokasi_jaminan_options = ['Yogyakarta', 'Luar Yogyakarta']

    for i in range(num_records):
        app_type = random.choice(['Pegawai', 'UMKM/Pengusaha'])
        record = {'application_type': app_type}

        # Common fields (even if not always used by model, they are in the form)
        record['plafond_pengajuan'] = round(random.uniform(5_000_000, 500_000_000), 2)
        record['jangka_waktu_kredit'] = random.randint(6, 72)

        # Initialize all other fields to NaN or appropriate default
        record.update({
            'usia': np.nan, 'masa_kerja': np.nan, 'golongan_jabatan': np.nan, 'status_kepegawaian': np.nan,
            'gaji_bulanan': np.nan, 'jumlah_tanggungan': np.nan, 'riwayat_kredit': np.nan,
            'omzet_usaha': np.nan, 'lama_usaha': np.nan, 'sektor_ekonomi': np.nan, 'lokasi_usaha': np.nan,
            'riwayat_pinjaman': np.nan, 'jenis_penggunaan_kredit': np.nan, 'jenis_jaminan': np.nan,
            'sumber_dana_pengembalian': np.nan, 'keputusan_kredit': np.nan
        })

        if app_type == 'Pegawai':
            record['usia'] = random.randint(20, 60)
            record['masa_kerja'] = random.randint(0, 35)
            # Pekerjaan mudah/umum di Jogja
            record['golongan_jabatan'] = random.choice(['Staf Pelaksana', 'Administrasi', 'Staf Senior', 'Supervisor'])
            record['status_kepegawaian'] = random.choice(status_kepegawaian)
            record['gaji_bulanan'] = round(random.uniform(4_000_000, 30_000_000), 2) # Gaji lebih bervariasi
            record['jumlah_tanggungan'] = random.randint(0, 5)
            record['riwayat_kredit'] = random.choice(riwayat_kredit)

            # Untuk Pegawai, jenis_penggunaan_kredit dan sumber_dana_pengembalian bisa kosong atau diisi
            if random.random() < 0.7: # 70% diisi
                record['jenis_penggunaan_kredit'] = random.choice(jenis_penggunaan_kredit_pegawai)
                record['sumber_dana_pengembalian'] = random.choice(sumber_dana_pengembalian_pegawai)
            else: # 30% kosong
                record['jenis_penggunaan_kredit'] = np.nan
                record['sumber_dana_pengembalian'] = np.nan

            # Logika keputusan kredit untuk Pegawai (sederhana)
            score = 0
            if record['gaji_bulanan'] > 8_000_000: score += 1
            if record['masa_kerja'] > 5: score += 1
            if record['riwayat_kredit'] == 'Tidak Ada': score += 2
            if record['riwayat_kredit'] == 'Ada': score += 1
            if record['jumlah_tanggungan'] < 3: score += 1
            if record['plafond_pengajuan'] < record['gaji_bulanan'] * 10: score += 1 # Plafon wajar

            if score >= 4:
                record['keputusan_kredit'] = 'Layak'
            elif score >= 2:
                record['keputusan_kredit'] = 'Pertimbangkan'
            else:
                record['keputusan_kredit'] = 'Tidak Layak'

        else: # UMKM/Pengusaha
            record['omzet_usaha'] = round(random.uniform(5_000_000, 200_000_000), 2)
            record['lama_usaha'] = random.randint(1, 15)
            record['sektor_ekonomi'] = random.choice(sektor_ekonomi)
            record['lokasi_usaha'] = random.choice(lokasi_usaha_umkm)
            record['riwayat_pinjaman'] = random.choice(riwayat_pinjaman_umkm)
            record['jenis_penggunaan_kredit'] = random.choice(jenis_penggunaan_kredit_umkm)
            record['sumber_dana_pengembalian'] = random.choice(sumber_dana_pengembalian_umkm)

            # Logika keputusan kredit untuk UMKM (sederhana)
            score = 0
            if record['omzet_usaha'] > 30_000_000: score += 2
            if record['lama_usaha'] > 5: score += 1
            if record['riwayat_pinjaman'] == 'Tidak Ada': score += 2
            if record['riwayat_pinjaman'] == 'Ada': score += 1
            if record['sektor_ekonomi'] in ['IT', 'Jasa', 'Kuliner']: score += 1 # Sektor favorit
            if record['lokasi_usaha'] in ['Yogyakarta Kota', 'Sleman']: score += 1 # Lokasi strategis

            if score >= 4:
                record['keputusan_kredit'] = 'Layak'
            elif score >= 2:
                record['keputusan_kredit'] = 'Pertimbangkan'
            else:
                record['keputusan_kredit'] = 'Tidak Layak'

        # Informasi Jaminan (untuk kedua tipe aplikasi)
        jenis_jaminan_pilihan = random.choice(jenis_jaminan_umkm) # Re-use for simplicity
        record['jenis_jaminan'] = jenis_jaminan_pilihan
        
        # Tambahkan lokasi jaminan ke dalam collateral_details (sebagai string JSON)
        collateral_details = {}
        if jenis_jaminan_pilihan == 'Bangunan':
            collateral_details['luas_bangunan'] = round(random.uniform(50, 500), 2)
            collateral_details['alamat_jaminan_bangunan'] = fake.address()
            collateral_details['lokasi_jaminan'] = random.choice(lokasi_jaminan_options)
        elif jenis_jaminan_pilihan == 'Kendaraan':
            collateral_details['merk_kendaraan'] = random.choice(['Toyota', 'Honda', 'Suzuki', 'Mitsubishi'])
            collateral_details['tahun_kendaraan'] = random.randint(2000, 2024)
            collateral_details['atas_nama_kendaraan'] = fake.name()
            collateral_details['lokasi_jaminan'] = random.choice(lokasi_jaminan_options)
        # Untuk jenis jaminan lain, collateral_details bisa kosong atau hanya berisi lokasi
        elif jenis_jaminan_pilihan != 'Tidak Ada':
            collateral_details['lokasi_jaminan'] = random.choice(lokasi_jaminan_options)
            collateral_details['deskripsi'] = fake.word() # Contoh detail lain
        
        # Simpan collateral_details sebagai string JSON
        record['collateral_details'] = json.dumps(collateral_details) if collateral_details else np.nan


        data.append(record)

    df = pd.DataFrame(data)
    # Re-order columns to match the original CSV header
    ordered_columns = [
        'application_type', 'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
        'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit', 'keputusan_kredit',
        'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
        'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'jenis_jaminan',
        'sumber_dana_pengembalian', 'plafond_pengajuan', 'jangka_waktu_kredit',
        'collateral_details' # Tambahkan kolom ini, ini akan disimpan sebagai JSON string
    ]
    df = df[ordered_columns]

    # Simpan ke CSV
    df.to_csv('bpr_dummy_data.csv', index=False)
    print(f"Generated {num_records} records and saved to bpr_dummy_data.csv")
    print("\nBerikut adalah beberapa baris pertama dari data yang dihasilkan:")
    print(df.head())
    print("\nDistribusi Keputusan Kredit:")
    print(df['keputusan_kredit'].value_counts())
    print("\nDistribusi Tipe Aplikasi:")
    print(df['application_type'].value_counts())

# Jalankan fungsi untuk menghasilkan data
if __name__ == "__main__":
    generate_dummy_data(num_records=500) # Bisa disesuaikan jumlah recordnya