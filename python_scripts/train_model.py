import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import pickle
import os

def train_and_save_model(data_df, model_type, features, categorical_features, target_col):
    print(f"Starting training for {model_type} model...")

    df_filtered = data_df[data_df['application_type'] == model_type].copy()

    # Pre-fill NaN/empty strings in features before dropping rows to ensure all features are processed
    # This also ensures consistent types before training/encoding
    for feature in features:
        if feature not in df_filtered.columns:
            # If a feature column is entirely missing in the filtered data, add it with default
            if feature in categorical_features:
                df_filtered[feature] = ''
            else:
                df_filtered[feature] = 0.0
        else:
            # For existing columns, ensure correct type and fill NaNs
            if feature in categorical_features:
                df_filtered[feature] = df_filtered[feature].astype(str).fillna('')
            else:
                df_filtered[feature] = pd.to_numeric(df_filtered[feature], errors='coerce').fillna(0.0)

    # Drop rows where the TARGET COLUMN is NaN (i.e., no 'keputusan_kredit')
    df_filtered.dropna(subset=[target_col], inplace=True)

    X = df_filtered[features]
    y = df_filtered[target_col]

    target_mapping = {'Tidak Layak': 0, 'Pertimbangkan': 1, 'Layak': 2}
    y_encoded = y.map(target_mapping)

    label_encoders = {}
    for col in categorical_features:
        if col in X.columns:
            le = LabelEncoder()
            # Fit LabelEncoder on unique values including empty string if present
            X[col] = le.fit_transform(X[col]) # X[col] should already be string type from previous step
            le_filename = os.path.join(os.path.dirname(__file__), f"{model_type.lower().replace('/', '_')}_label_encoder_{col}.pkl")
            with open(le_filename, 'wb') as f:
                pickle.dump(le, f)
            label_encoders[col] = le
            print(f"Saved label encoder for '{col}' ({model_type}) to {le_filename}")
        else:
            print(f"Warning: Categorical feature '{col}' not found in DataFrame for {model_type} model during training. Skipping LabelEncoder for this feature.", file=sys.stderr)


    X_train, X_test, y_train, y_test = train_test_split(X, y_encoded, test_size=0.2, random_state=42)

    model = RandomForestClassifier(n_estimators=100, random_state=42)
    model.fit(X_train, y_train)

    y_pred = model.predict(X_test)
    print(f"\nAccuracy Score ({model_type}): {accuracy_score(y_test, y_pred)}")
    print(f"Classification Report ({model_type}):\n{classification_report(y_test, y_pred, target_names=['Tidak Layak', 'Pertimbangkan', 'Layak'])}")

    model_filename = os.path.join(os.path.dirname(__file__), f"{model_type.lower().replace('/', '_')}_model.pkl")
    with open(model_filename, 'wb') as f:
        pickle.dump(model, f)
    print(f"\nModel for {model_type} saved successfully to {model_filename}")

if __name__ == "__main__":
    data_file = os.path.join(os.path.dirname(__file__), 'bpr_dummy_data.csv')
    df = pd.read_csv(data_file)

    # --- Data Cleaning (Penting!) ---
    df['riwayat_kredit'] = df['riwayat_kredit'].replace('Pernak Macet', 'Pernah Macet')
    df['riwayat_pinjaman'] = df['riwayat_pinjaman'].replace('Pernak Macet', 'Pernah Macet')

    # --- Definisi Fitur untuk Model Pegawai ---
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
    employee_target = 'keputusan_kredit'

    # --- Definisi Fitur untuk Model UMKM/Pengusaha ---
    umkm_features = [
        'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
        'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'jenis_jaminan',
        'sumber_dana_pengembalian', 'plafond_pengajuan', 'jangka_waktu_kredit'
    ]
    umkm_categorical_features = [
        'sektor_ekonomi', 'lokasi_usaha', 'riwayat_pinjaman',
        'jenis_penggunaan_kredit', 'jenis_jaminan', 'sumber_dana_pengembalian'
    ]
    umkm_target = 'keputusan_kredit'

    try:
        train_and_save_model(df.copy(), 'Pegawai', employee_features, employee_categorical_features, employee_target)
    except Exception as e:
        print(f"Error training employee model: {e}", file=sys.stderr)

    print("\n" + "="*50 + "\n")

    try:
        train_and_save_model(df.copy(), 'UMKM/Pengusaha', umkm_features, umkm_categorical_features, umkm_target)
    except Exception as e:
        print(f"Error training UMKM/Pengusaha model: {e}", file=sys.stderr)

    print("\nTraining process completed. .pkl files should be generated in the python_scripts directory.")