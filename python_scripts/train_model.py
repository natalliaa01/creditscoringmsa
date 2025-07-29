# python_scripts/train_model.py
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder, OneHotEncoder, StandardScaler
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import joblib
import warnings
import sys
import os # Import os module
import numpy as np # Import numpy for np.nan

# Suppress warnings for cleaner output during training
warnings.filterwarnings("ignore")

def train_and_save_model(df, model_type, model_filename, encoder_filename):
    """
    Melatih model ML untuk tipe aplikasi tertentu dan menyimpannya.
    """
    print(f"--- Training {model_type} Model ---")

    if 'keputusan_kredit' not in df.columns or df['keputusan_kredit'].isnull().all():
        print(f"Error: 'keputusan_kredit' column missing or empty in {model_type} data.")
        return

    df.dropna(subset=['keputusan_kredit'], inplace=True)
    if df.empty:
        print(f"No data after dropping missing target values for {model_type}.")
        return

    X = df.drop('keputusan_kredit', axis=1)
    y = df['keputusan_kredit']

    label_encoder = LabelEncoder()
    y_encoded = label_encoder.fit_transform(y)
    # Gunakan os.path.join untuk membuat jalur yang benar dan eksplisit
    joblib.dump(label_encoder, os.path.join('python_scripts', encoder_filename))
    print(f"Label Encoder saved to {os.path.join('python_scripts', encoder_filename)}")

    if model_type == 'UMKM/Pengusaha':
        numerical_features = ['omzet_usaha', 'lama_usaha', 'plafond_pengajuan', 'jangka_waktu_kredit']
        categorical_features = ['sektor_ekonomi', 'lokasi_usaha', 'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'jenis_jaminan', 'sumber_dana_pengembalian']
    elif model_type == 'Pegawai':
        numerical_features = ['usia', 'masa_kerja', 'gaji_bulanan', 'jumlah_tanggungan', 'plafond_pengajuan', 'jangka_waktu_kredit']
        categorical_features = ['golongan_jabatan', 'status_kepegawaian', 'riwayat_kredit', 'jenis_penggunaan_kredit', 'jenis_jaminan', 'sumber_dana_pengembalian']
    else:
        print(f"Unknown model type: {model_type}")
        return

    # Inisialisasi X_selected dengan semua fitur yang relevan dari X
    # Pastikan semua fitur yang diharapkan ada di DataFrame, isi dengan NaN jika tidak ada
    all_expected_features = numerical_features + categorical_features
    for feature in all_expected_features:
        if feature not in X.columns:
            X[feature] = np.nan # Isi dengan NaN jika fitur tidak ada di data asli

    X_selected = X[all_expected_features] # Buat X_selected di sini

    preprocessor = ColumnTransformer(
        transformers=[
            ('num', StandardScaler(), numerical_features),
            ('cat', OneHotEncoder(handle_unknown='ignore'), categorical_features)
        ],
        remainder='drop'
    )

    model_pipeline = Pipeline(steps=[('preprocessor', preprocessor),
                                       ('classifier', RandomForestClassifier(random_state=42))])

    X_train, X_test, y_train, y_test = train_test_split(X_selected, y_encoded, test_size=0.2, random_state=42, stratify=y_encoded)

    model_pipeline.fit(X_train, y_train)

    y_pred = model_pipeline.predict(X_test)
    print(f"{model_type} Model Accuracy: {accuracy_score(y_test, y_pred):.2f}")
    print(f"{model_type} Classification Report:\n{classification_report(y_test, y_pred, target_names=label_encoder.classes_)}")

    # Gunakan os.path.join untuk membuat jalur yang benar dan eksplisit
    joblib.dump(model_pipeline, os.path.join('python_scripts', model_filename))
    print(f"Model saved to {os.path.join('python_scripts', model_filename)}")

# --- Main Training Script ---
if __name__ == '__main__':
    # Pastikan jalur ini menunjuk ke file CSV dummy Anda
    try:
        df_full = pd.read_csv(os.path.join('python_scripts', 'bpr_dummy_data.csv'))
    except FileNotFoundError:
        print("Error: Data file 'python_scripts/bpr_dummy_data.csv' not found.")
        print("Please ensure you have run generate_dummy_data.py first.")
        sys.exit(1)

    df_umkm = df_full[df_full['application_type'] == 'UMKM/Pengusaha'].copy()
    train_and_save_model(df_umkm, 'UMKM/Pengusaha', 'umkm_model.pkl', 'umkm_label_encoder.pkl')

    df_employee = df_full[df_full['application_type'] == 'Pegawai'].copy()
    train_and_save_model(df_employee, 'Pegawai', 'employee_model.pkl', 'employee_label_encoder.pkl')

    print("\nTraining complete. Models and encoders saved.")
