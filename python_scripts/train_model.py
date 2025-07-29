# python_scripts/train_model.py
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder, OneHotEncoder, StandardScaler
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.linear_model import LogisticRegression
from sklearn.ensemble import RandomForestClassifier # Contoh algoritma lain
from sklearn.metrics import accuracy_score, classification_report
import joblib
import warnings

# Suppress warnings for cleaner output during training
warnings.filterwarnings("ignore")

def train_and_save_model(df, model_type, model_filename, encoder_filename):
    """
    Melatih model ML untuk tipe aplikasi tertentu dan menyimpannya.
    """
    print(f"--- Training {model_type} Model ---")

    # Pastikan kolom target ada dan tidak kosong
    if 'keputusan_kredit' not in df.columns or df['keputusan_kredit'].isnull().all():
        print(f"Error: 'keputusan_kredit' column missing or empty in {model_type} data.")
        return

    df.dropna(subset=['keputusan_kredit'], inplace=True)
    if df.empty:
        print(f"No data after dropping missing target values for {model_type}.")
        return

    # Pisahkan fitur (X) dan target (y)
    X = df.drop('keputusan_kredit', axis=1)
    y = df['keputusan_kredit']

    # Encoding target (Layak/Tidak Layak menjadi 0/1)
    label_encoder = LabelEncoder()
    y_encoded = label_encoder.fit_transform(y)
    joblib.dump(label_encoder, encoder_filename)
    print(f"Label Encoder saved to {encoder_filename}")

    # Definisikan fitur numerik dan kategorikal berdasarkan tipe model
    if model_type == 'UMKM/Pengusaha':
        numerical_features = ['omzet_usaha', 'lama_usaha', 'plafond_pengajuan', 'jangka_waktu_kredit']
        categorical_features = ['sektor_ekonomi', 'lokasi_usaha', 'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'jenis_jaminan', 'sumber_dana_pengembalian']
    elif model_type == 'Pegawai':
        numerical_features = ['usia', 'masa_kerja', 'gaji_bulanan', 'jumlah_tanggungan']
        categorical_features = ['golongan_jabatan', 'status_kepegawaian', 'riwayat_kredit']
    else:
        print(f"Unknown model type: {model_type}")
        return

    # Pastikan hanya fitur yang relevan yang ada di X
    # Ini penting karena data input dari Laravel mungkin tidak memiliki semua kolom
    # yang ada di dataset training jika Anda melatih satu model untuk semua
    X_selected = X[numerical_features + categorical_features]

    # Pra-pemrosesan: Imputasi dan Encoding
    preprocessor = ColumnTransformer(
        transformers=[
            ('num', StandardScaler(), numerical_features), # Skala numerik
            ('cat', OneHotEncoder(handle_unknown='ignore'), categorical_features) # One-Hot encode kategorikal
        ],
        remainder='drop' # Buang kolom yang tidak disebutkan
    )

    # Buat pipeline model
    # Anda bisa mencoba RandomForestClassifier atau algoritma lain di sini
    model_pipeline = Pipeline(steps=[('preprocessor', preprocessor),
                                       ('classifier', RandomForestClassifier(random_state=42))]) # Menggunakan RandomForest

    # Bagi data menjadi training dan testing
    X_train, X_test, y_train, y_test = train_test_split(X_selected, y_encoded, test_size=0.2, random_state=42, stratify=y_encoded)

    # Latih model
    model_pipeline.fit(X_train, y_train)

    # Evaluasi model
    y_pred = model_pipeline.predict(X_test)
    print(f"{model_type} Model Accuracy: {accuracy_score(y_test, y_pred):.2f}")
    print(f"{model_type} Classification Report:\n{classification_report(y_test, y_pred, target_names=label_encoder.classes_)}")

    # Simpan model
    joblib.dump(model_pipeline, model_filename)
    print(f"Model saved to {model_filename}")

# --- Main Training Script ---
if __name__ == '__main__':
    # Ganti 'path/to/your_bpr_data.csv' dengan lokasi file data historis Anda
    # Pastikan file ini berisi kolom 'application_type' dan 'keputusan_kredit'
    try:
        df_full = pd.read_csv('python_scripts/bpr_dummy_data.csv') # Pastikan jalur ini benar
    except FileNotFoundError:
        print("Error: Data file 'python_scripts/bpr_dummy_data.csv' not found.")
        print("Please ensure you have run generate_dummy_data.py first.")
        sys.exit(1)

    # Filter data untuk UMKM/Pengusaha
    df_umkm = df_full[df_full['application_type'] == 'UMKM/Pengusaha'].copy()
    train_and_save_model(df_umkm, 'UMKM/Pengusaha', 'umkm_model.pkl', 'umkm_label_encoder.pkl')

    # Filter data untuk Pegawai
    df_employee = df_full[df_full['application_type'] == 'Pegawai'].copy()
    train_and_save_model(df_employee, 'Pegawai', 'employee_model.pkl', 'employee_label_encoder.pkl')

    print("\nTraining complete. Models and encoders saved.")
