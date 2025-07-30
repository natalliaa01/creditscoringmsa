import sys
import json
import pickle
import pandas as pd
import os

REVERSE_TARGET_MAPPING = {0: 'Tidak Layak', 1: 'Pertimbangkan', 2: 'Layak'}

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
    for feature in feature_list: # Loop melalui fitur kategorikal yang diharapkan
        le_path = os.path.join(os.path.dirname(__file__), f"{model_type.lower().replace('/', '_')}_label_encoder_{feature}.pkl")
        if os.path.exists(le_path):
            try:
                with open(le_path, 'rb') as f:
                    label_encoders[feature] = pickle.load(f)
            except Exception as e:
                print(f"Warning: Could not unpickle label encoder for '{feature}' from {le_path}. Error: {e}", file=sys.stderr)
        else:
            # Penting: jika encoder tidak ditemukan, kita tetap perlu menanganinya.
            print(f"Warning: Label encoder file not found for '{feature}': {le_path}. This feature will be treated with a default value (e.g., 0 after encoding).", file=sys.stderr)

    return model, label_encoders

def preprocess_input(data, model_type, label_encoders, expected_features, categorical_features):
    df = pd.DataFrame([data])

    # Data Cleaning: Perbaiki typo 'Pernak Macet' menjadi 'Pernah Macet'
    if 'riwayat_kredit' in df.columns:
        df['riwayat_kredit'] = df['riwayat_kredit'].replace('Pernak Macet', 'Pernah Macet')
    if 'riwayat_pinjaman' in df.columns:
        df['riwayat_pinjaman'] = df['riwayat_pinjaman'].replace('Pernak Macet', 'Pernah Macet')

    # Pastikan semua kolom yang diharapkan model ada dan isi nilai yang hilang/kosong
    for col in expected_features:
        if col not in df.columns or pd.isna(df[col]).iloc[0] or (isinstance(df[col].iloc[0], str) and df[col].iloc[0].strip() == ''):
            if col in categorical_features:
                df[col] = '' # Isi dengan string kosong untuk kategorikal yang hilang/kosong
            else:
                df[col] = 0.0 # Isi dengan 0.0 untuk numerik yang hilang/kosong

    # Pastikan urutan kolom sesuai dengan urutan saat model dilatih
    df = df[expected_features]

    # Terapkan Label Encoding untuk fitur kategorikal
    for col in categorical_features:
        if col in df.columns:
            current_value_str = str(df[col].iloc[0]) # Ensure it's a string

            if col in label_encoders:
                le = label_encoders[col]
                try:
                    # Transform value
                    df[col] = le.transform([current_value_str])[0]
                except ValueError:
                    # Handle unknown categories: use a default value (e.g., 0)
                    print(f"Warning: Unknown category '{current_value_str}' for feature '{col}'. Using 0.", file=sys.stderr)
                    df[col] = 0 # Fallback to 0 if category is unknown to encoder
            else:
                # If no encoder was loaded for this feature (e.g., all values were NaN/empty during training)
                # Treat it as a default numerical value (0)
                print(f"Warning: No label encoder loaded for categorical feature '{col}'. Treating value '{current_value_str}' as 0.", file=sys.stderr)
                df[col] = 0 # Default numerical value for unencoded categorical


    # Konversi tipe data numerik
    for col in expected_features:
        if col not in categorical_features: # Hanya konversi yang bukan kategorikal
            df[col] = pd.to_numeric(df[col], errors='coerce').fillna(0.0) # Convert to numeric, fill NaN with 0.0

    return df


if __name__ == "__main__":
    if len(sys.argv) < 3:
        print(json.dumps({'error': 'Usage: python scoring.py <json_data> <model_type>'}), file=sys.stderr)
        sys.exit(1)

    input_json_string = sys.argv[1]
    model_type = sys.argv[2] # 'Pegawai' atau 'UMKM/Pengusaha'

    # --- Definisi Fitur untuk Kedua Model (Harus Konsisten dengan train_model.py) ---
    employee_features = [
        'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
        'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit',
        'jenis_penggunaan_kredit', 'sumber_dana_pengembalian', # DITAMBAHKAN
        'plafond_pengajuan', 'jangka_waktu_kredit'
    ]
    employee_categorical_features = [
        'golongan_jabatan', 'status_kepegawaian', 'riwayat_kredit',
        'jenis_penggunaan_kredit', 'sumber_dana_pengembalian' # DITAMBAHKAN
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

    try:
        input_data = json.loads(input_json_string)

        if model_type == 'Pegawai':
            current_features = employee_features
            current_categorical_features = employee_categorical_features
        elif model_type == 'UMKM/Pengusaha':
            current_features = umkm_features
            current_categorical_features = umkm_categorical_features
        else:
            raise ValueError(f"Invalid model_type: {model_type}. Must be 'Pegawai' or 'UMKM/Pengusaha'.")

        model, label_encoders = load_assets(model_type, current_categorical_features)
        processed_df = preprocess_input(input_data, model_type, label_encoders, current_features, current_categorical_features)

        # Predict
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
        print(json.dumps(result))

    except FileNotFoundError as fnf_e:
        print(json.dumps({'error': f'Python Error: File model atau encoder tidak ditemukan: {str(fnf_e)}'}), file=sys.stderr)
        sys.exit(1)
    except ValueError as ve:
        print(json.dumps({'error': f'Python Error: Kesalahan nilai atau format: {str(ve)}'}), file=sys.stderr)
        sys.exit(1)
    except json.JSONDecodeError:
        print(json.dumps({'error': 'Python Error: Input JSON tidak valid.'}), file=sys.stderr)
        sys.exit(1)
    except Exception as e:
        print(json.dumps({'error': f'Python Error Umum: {str(e)}'}), file=sys.stderr)
        sys.exit(1)