# python_scripts/scoring.py
import sys
import json
import pandas as pd
import joblib # Untuk memuat model yang sudah dilatih

# Muat model yang sudah dilatih dan label encoder saat skrip dimulai
# Pastikan path ini benar relatif terhadap lokasi skrip scoring.py
try:
    UMKM_MODEL = joblib.load('python_scripts/umkm_model.pkl')
    EMPLOYEE_MODEL = joblib.load('python_scripts/employee_model.pkl')
    UMKM_LABEL_ENCODER = joblib.load('python_scripts/umkm_label_encoder.pkl')
    EMPLOYEE_LABEL_ENCODER = joblib.load('python_scripts/employee_label_encoder.pkl')
except FileNotFoundError as e:
    # Mengarahkan pesan error ke stderr agar tidak mengganggu output JSON
    print(json.dumps({'error': f'Model files not found: {e}. Please train and save the models first by running train_model.py.'}), file=sys.stderr)
    sys.exit(1)
except Exception as e:
    print(json.dumps({'error': f'Error loading models: {str(e)}'}), file=sys.stderr)
    sys.exit(1)


def predict_score_and_recommendation(application_type, data):
    """
    Menggunakan model ML yang sudah dilatih untuk memprediksi skor dan rekomendasi.
    """
    try:
        # Konversi data input ke DataFrame yang sesuai dengan format training
        df_input = pd.DataFrame([data])

        score = 0
        predicted_status = "Pending"
        recommendation_details = []

        if application_type == 'UMKM/Pengusaha':
            model = UMKM_MODEL
            label_encoder = UMKM_LABEL_ENCODER
            # Pastikan semua kolom yang diharapkan oleh model ada, bahkan jika kosong
            # Ini harus mencocokkan fitur yang digunakan saat training UMKM_MODEL
            expected_umkm_features = [
                'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
                'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'jenis_jaminan',
                'sumber_dana_pengembalian', 'plafond_pengajuan', 'jangka_waktu_kredit'
            ]
            for feature in expected_umkm_features:
                if feature not in df_input.columns:
                    df_input[feature] = None # Atau nilai default yang sesuai

        elif application_type == 'Pegawai':
            model = EMPLOYEE_MODEL
            label_encoder = EMPLOYEE_LABEL_ENCODER
            # Pastikan semua kolom yang diharapkan oleh model ada, bahkan jika kosong
            # Ini harus mencocokkan fitur yang digunakan saat training EMPLOYEE_MODEL
            expected_employee_features = [
                'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
                'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit',
                # Fitur detail pinjaman baru
                'jenis_penggunaan_kredit', 'jenis_jaminan', 'sumber_dana_pengembalian',
                'plafond_pengajuan', 'jangka_waktu_kredit'
            ]
            for feature in expected_employee_features:
                if feature not in df_input.columns:
                    df_input[feature] = None # Atau nilai default yang sesuai
        else:
            return 0, "Pending", ["Tipe aplikasi tidak dikenal."]

        # Prediksi menggunakan model yang dipilih
        prediction_encoded = model.predict(df_input)[0]
        prediction_proba = model.predict_proba(df_input)[0] # Probabilitas kelas

        # Konversi prediksi kembali ke label asli (Layak/Tidak Layak)
        predicted_status = label_encoder.inverse_transform([prediction_encoded])[0]

        # Contoh sederhana untuk skor numerik berdasarkan probabilitas
        # Anda bisa menyesuaikan logika skor ini. Misalnya, probabilitas Layak * 100.
        # Pastikan 'Layak' adalah salah satu kelas yang dikenal oleh encoder
        if 'Layak' in label_encoder.classes_:
            score = int(prediction_proba[label_encoder.transform(['Layak'])[0]] * 100)
        else:
            score = int(prediction_proba[prediction_encoded] * 100) # Jika 'Layak' tidak ada, ambil probabilitas kelas yang diprediksi

        # Rekomendasi berdasarkan status
        if predicted_status == 'Layak':
            recommendation_details.append("Aplikasi ini direkomendasikan untuk disetujui berdasarkan analisis model.")
            recommendation_details.append(f"Probabilitas Layak: {prediction_proba[label_encoder.transform(['Layak'])[0]]*100:.2f}%")
        elif predicted_status == 'Tidak Layak':
            recommendation_details.append("Aplikasi ini direkomendasikan untuk ditolak berdasarkan analisis model.")
            recommendation_details.append(f"Probabilitas Tidak Layak: {prediction_proba[label_encoder.transform(['Tidak Layak'])[0]]*100:.2f}%")
            # TODO: Tambahkan detail mengapa tidak layak (misalnya, fitur yang paling berpengaruh)
            # Ini memerlukan analisis lebih lanjut dari model (misalnya, feature importance untuk tree-based models)
        else:
            recommendation_details.append("Status tidak dapat ditentukan oleh model.")


        return score, predicted_status, recommendation_details

    except Exception as e:
        # Log error ke stderr agar tidak mengganggu output JSON
        print(json.dumps({'error': f'Terjadi kesalahan saat memprediksi: {str(e)}'}), file=sys.stderr)
        return 0, "Error", [f"Terjadi kesalahan saat memprediksi: {str(e)}"]

def main():
    # Ambil argumen dari command line (akan berupa string JSON)
    if len(sys.argv) < 2:
        print(json.dumps({'error': 'No input data provided.'}), file=sys.stderr)
        sys.exit(1)

    try:
        input_data_json = sys.argv[1]
        input_data = json.loads(input_data_json)
    except json.JSONDecodeError as e:
        print(json.dumps({'error': f'Invalid JSON input: {e}'}), file=sys.stderr)
        sys.exit(1)
    except Exception as e:
        print(json.dumps({'error': f'Error processing input: {e}'}), file=sys.stderr)
        sys.exit(1)


    application_type = input_data.get('application_type')
    application_data = input_data.get('data', {})

    score, status_rekomendasi, recommendation_details = predict_score_and_recommendation(application_type, application_data)

    # Format output sebagai JSON
    output = {
        'score': score,
        'recommendation': {
            'status': status_rekomendasi,
            'details': recommendation_details
        },
        'status': status_rekomendasi # Update status di Laravel
    }

    print(json.dumps(output))

if __name__ == '__main__':
    main()

