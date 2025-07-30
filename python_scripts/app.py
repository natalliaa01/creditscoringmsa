import sys
import json
import pickle
import pandas as pd
import os
from flask import Flask, request, jsonify # Import Flask

# Inisialisasi aplikasi Flask
app = Flask(__name__)

# Mapping balik dari numerik ke label keputusan kredit
REVERSE_TARGET_MAPPING = {0: 'Tidak Layak', 1: 'Pertimbangkan', 2: 'Layak'}

# --- Definisi Fitur untuk Kedua Model (HARUS KONSISTEN dengan train_model.py) ---
employee_features = [
    'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
    'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit',
    'jenis_penggunaan_kredit', 'sumber_dana_pengembalian',
    'plafond_pengajuan', 'jangka_waktu_kredit'
]
employee_categorical_features = [
    'golongan_jabatan', 'status_kepegawaian', 'riwayat_kredit',
    'jenis_penggunaan_kredit', 'sumber_dana_pengembalian'
]

umkm_features = [
    'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
    'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'jenis_jaminan',
    'sumber_dana_pengembalian', 'plafond_pengajuan', 'jangka_waktu_kredit'
]
umkm_categorical_features = [
    'sektor_ekonomi', 'lokasi_usaha', 'riwayat_pinjaman',
    'jenis_penggunaan_kredit', 'jenis_jaminan', 'sumber_dana_pengembalian'
]


# Fungsi untuk memuat model dan encoder (DIREUSE dari scoring.py)
def load_assets(model_type, feature_list):
    model_path = os.path.join(os.path.dirname(__file__), f"{model_type.lower().replace('/', '_')}_model.pkl")

    if not os.path.exists(model_path):
        raise FileNotFoundError(f"Model file not found: {model_path}")

    model = None
    try:
        with open(model_path, 'rb') as f:
            model = pickle.load(f)
    except Exception as e:
        raise ValueError(f"Could not unpickle model from {model_path}. Error: {e}")

    label_encoders = {}
    for feature in feature_list:
        le_path = os.path.join(os.path.dirname(__file__), f"{model_type.lower().replace('/', '_')}_label_encoder_{feature}.pkl")
        if os.path.exists(le_path):
            try:
                with open(le_path, 'rb') as f:
                    label_encoders[feature] = pickle.load(f)
            except Exception as e:
                # Log warning if encoder load fails, but don't stop process
                print(f"Warning: Could not unpickle label encoder for '{feature}' from {le_path}. Error: {e}", file=sys.stderr)
        else:
            print(f"Warning: Label encoder file not found for '{feature}': {le_path}. This feature might be treated with a default value.", file=sys.stderr)

    return model, label_encoders

# Fungsi untuk melakukan preprocessing data input (DIREUSE dari scoring.py)
def preprocess_input(data, model_type, label_encoders, expected_features, categorical_features):
    df = pd.DataFrame([data])

    # Data Cleaning: Perbaiki typo 'Pernak Macet' menjadi 'Pernah Macet'
    if 'riwayat_kredit' in df.columns:
        df['riwayat_kredit'] = df['riwayat_kredit'].replace('Pernak Macet', 'Pernah Macet')
    if 'riwayat_pinjaman' in df.columns:
        df['riwayat_pinjaman'] = df['riwayat_pinjaman'].replace('Pernak Macet', 'Pernah Macet')

    # Pastikan semua kolom yang diharapkan model ada dan isi nilai yang hilang/kosong
    for col in expected_features:
        if col not in df.columns or df[col].isnull().all() or (isinstance(df[col].iloc[0], str) and df[col].iloc[0].strip() == ''):
            if col in categorical_features:
                df[col] = ''
            else:
                df[col] = 0.0
    
    # Pastikan urutan kolom sesuai dengan urutan saat model dilatih
    df = df[expected_features]

    # Terapkan Label Encoding untuk fitur kategorikal
    for col in categorical_features:
        if col in df.columns:
            current_value_str = str(df[col].iloc[0])

            if col in label_encoders:
                le = label_encoders[col]
                try:
                    df[col] = le.transform([current_value_str])[0]
                except ValueError:
                    print(f"Warning: Unknown category '{current_value_str}' for feature '{col}'. Using 0.", file=sys.stderr)
                    df[col] = 0
            else:
                print(f"Warning: No label encoder loaded for categorical feature '{col}'. Treating value '{current_value_str}' as 0.", file=sys.stderr)
                df[col] = 0

    # Konversi tipe data numerik
    for col in expected_features:
        if col not in categorical_features:
            df[col] = pd.to_numeric(df[col], errors='coerce').fillna(0.0)

    return df

# Endpoint API untuk scoring
@app.route('/score', methods=['POST'])
def score_application():
    try:
        # Ambil data dari request JSON
        request_data = request.get_json()
        if not request_data:
            return jsonify({'error': 'No JSON data provided'}), 400

        input_data = request_data.get('data')
        model_type = request_data.get('model_type')

        if not input_data or not model_type:
            return jsonify({'error': 'Missing "data" or "model_type" in request'}), 400

        # Tentukan fitur dan encoder berdasarkan jenis model
        if model_type == 'Pegawai':
            current_features = employee_features
            current_categorical_features = employee_categorical_features
        elif model_type == 'UMKM/Pengusaha':
            current_features = umkm_features
            current_categorical_features = umkm_categorical_features
        else:
            return jsonify({'error': f'Invalid model_type: {model_type}. Must be "Pegawai" or "UMKM/Pengusaha".'}), 400

        # Muat model dan label encoder
        model, label_encoders = load_assets(model_type, current_categorical_features)

        # Preprocess data
        processed_df = preprocess_input(input_data, model_type, label_encoders, current_features, current_categorical_features)

        # Lakukan prediksi
        prediction_proba = model.predict_proba(processed_df)[:, 2][0] # Probabilitas untuk kelas 'Layak' (indeks 2)
        prediction_class_encoded = model.predict(processed_df)[0]
        prediction_class_label = REVERSE_TARGET_MAPPING.get(prediction_class_encoded, "Unknown")

        score = float(prediction_proba * 100)

        result = {
            'status': 'success',
            'score': round(score, 2),
            'rekomendasi': prediction_class_label,
            'detail_prediksi': {
                'probabilitas_layak': round(float(prediction_proba), 4),
                'kelas_prediksi_raw': int(prediction_class_encoded)
            }
        }
        return jsonify(result), 200 # Kirim respons JSON dengan status 200 OK

    except FileNotFoundError as fnf_e:
        return jsonify({'error': f'Python Error: File model atau encoder tidak ditemukan: {str(fnf_e)}'}), 500
    except ValueError as ve:
        return jsonify({'error': f'Python Error: Kesalahan nilai atau format: {str(ve)}'}), 500
    except Exception as e:
        # Tangkap semua exception lain untuk debugging
        return jsonify({'error': f'Python Error Umum: {str(e)}'}), 500

if __name__ == '__main__':
    # Jalankan aplikasi Flask di port 5000 (default)
    # Host '0.0.0.0' agar bisa diakses dari luar localhost (jika perlu, tapi untuk dev cukup 127.0.0.1)
    app.run(host='127.0.0.1', port=5000, debug=False) # Ubah debug menjadi False # debug=True akan memberikan pesan error lebih detail