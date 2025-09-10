import torch
import torch.nn as nn
import torchvision.transforms as transforms
from flask import Flask, request, jsonify
from PIL import Image
import os

# ==================== KONFIGURASI (DISESUAIKAN DENGAN oil_palm_cnn.py) ====================
# Pastikan file model hasil training ada di folder yang sama dengan API ini
MODEL_PATH = 'best_oil_palm_model.pth' 

# Parameter yang HARUS SAMA dengan saat training
NUM_CLASSES = 4
GROUPS = 2
IMAGE_SIZE = 224
CLASS_NAMES = ['Daun Sehat', 'Daun Kuning', 'Daun Bercak', 'Daun Busuk'] # Urutan harus sesuai dengan label 0, 1, 2, 3

# Informasi tambahan untuk petani
INFO_PENYAKIT = {
    'Daun Sehat': {
        'deskripsi': 'Selamat! Daun kelapa sawit ini menunjukkan ciri-ciri sehat dan tidak terinfeksi penyakit serius. Pertahankan praktik perawatan yang baik.',
        'saran': 'Lanjutkan pemupukan teratur, pastikan drainase lahan baik, dan pantau terus kondisi daun secara berkala.'
    },
    'Daun Kuning': {
        'deskripsi': 'Daun kelapa sawit ini menunjukkan gejala menguning. Ini bisa disebabkan oleh kekurangan nutrisi (terutama Nitrogen, Magnesium, atau Kalium), kelebihan air, atau serangan hama/penyakit ringan.',
        'saran': 'Periksa pH tanah dan lakukan analisis daun untuk mengetahui defisiensi nutrisi. Berikan pupuk yang sesuai. Pastikan tidak ada genangan air.'
    },
    'Daun Bercak': {
        'deskripsi': 'Terdapat bercak-bercak pada daun, yang mengindikasikan infeksi jamur atau bakteri. Ini bisa mengganggu fotosintesis dan mengurangi hasil panen.',
        'saran': 'Segera buang dan musnahkan daun yang terinfeksi parah untuk mencegah penyebaran. Gunakan fungisida atau bakterisida yang direkomendasikan jika infeksi meluas.'
    },
    'Daun Busuk': {
        'deskripsi': 'Daun menunjukkan tanda-tanda pembusukan parah, kemungkinan besar karena infeksi jamur atau bakteri yang agresif.',
        'saran': 'Isolasi dan musnahkan tanaman yang terinfeksi parah untuk mencegah penyebaran ke tanaman lain. Lakukan sanitasi kebun secara menyeluruh.'
    }
}
# ===========================================================================================

# ==================== ARSITEKTUR MODEL (SALINAN IDENTIK DARI oil_palm_cnn.py) ====================
class GroupConv2d(nn.Module):
    def __init__(self, in_channels, out_channels, kernel_size, groups=1, stride=1, padding=0):
        super(GroupConv2d, self).__init__()
        self.conv = nn.Conv2d(in_channels, out_channels, kernel_size, 
                             stride=stride, padding=padding, groups=groups)
    def forward(self, x):
        return self.conv(x)

class FireModule(nn.Module):
    def __init__(self, in_channels, squeeze_channels, expand1x1_channels, expand3x3_channels, groups=1):
        super(FireModule, self).__init__()
        self.squeeze = nn.Sequential(
            GroupConv2d(in_channels, squeeze_channels, kernel_size=1, groups=groups),
            nn.BatchNorm2d(squeeze_channels),
            nn.ReLU(inplace=True)
        )
        self.expand1x1 = nn.Sequential(
            GroupConv2d(squeeze_channels, expand1x1_channels, kernel_size=1, groups=groups),
            nn.BatchNorm2d(expand1x1_channels),
            nn.ReLU(inplace=True)
        )
        self.expand3x3 = nn.Sequential(
            GroupConv2d(squeeze_channels, expand3x3_channels, kernel_size=3, padding=1, groups=groups),
            nn.BatchNorm2d(expand3x3_channels),
            nn.ReLU(inplace=True)
        )
    def forward(self, x):
        x = self.squeeze(x)
        return torch.cat([self.expand1x1(x), self.expand3x3(x)], dim=1)

class SqueezeNetGroupConv(nn.Module):
    def __init__(self, num_classes=4, groups=2):
        super(SqueezeNetGroupConv, self).__init__()
        self.features = nn.Sequential(
            GroupConv2d(3, 64, kernel_size=3, stride=2, padding=1, groups=1),
            nn.BatchNorm2d(64),
            nn.ReLU(inplace=True),
            nn.MaxPool2d(kernel_size=3, stride=2, padding=1),
            FireModule(64, 16, 64, 64, groups=groups),
            FireModule(128, 16, 64, 64, groups=groups),
            nn.MaxPool2d(kernel_size=3, stride=2, padding=1),
            FireModule(128, 32, 128, 128, groups=groups),
            FireModule(256, 32, 128, 128, groups=groups),
            nn.MaxPool2d(kernel_size=3, stride=2, padding=1),
            FireModule(256, 48, 192, 192, groups=groups),
            FireModule(384, 48, 192, 192, groups=groups),
            FireModule(384, 64, 256, 256, groups=groups),
            FireModule(512, 64, 256, 256, groups=groups),
        )
        self.classifier = nn.Sequential(
            nn.Dropout(0.5),
            GroupConv2d(512, num_classes, kernel_size=1, groups=1),
            nn.ReLU(inplace=True),
            nn.AdaptiveAvgPool2d((1, 1))
        )
    def forward(self, x):
        x = self.features(x)
        x = self.classifier(x)
        return x.view(x.size(0), -1)
# ===============================================================================================

# --- LOGIKA PEMUATAN MODEL DAN PREDIKSI ---
app = Flask(__name__)
device = torch.device("cpu")
model = None

try:
    # Inisialisasi model dengan arsitektur yang BENAR
    model = SqueezeNetGroupConv(num_classes=NUM_CLASSES, groups=GROUPS)
    # Memuat state_dict dari file hasil training
    model.load_state_dict(torch.load(MODEL_PATH, map_location=device))
    model.to(device)
    model.eval() # Set model ke mode evaluasi
    print(f"✅ Model '{MODEL_PATH}' berhasil dimuat ke CPU.")
except FileNotFoundError:
    print(f"❌ ERROR: File model '{MODEL_PATH}' tidak ditemukan!")
    print("Pastikan file hasil training sudah ada di folder yang sama dengan API ini.")
except Exception as e:
    print(f"❌ ERROR: Terjadi kesalahan saat memuat model: {e}")

# Transformasi gambar untuk prediksi (harus sama dengan test_transform)
preprocess_transform = transforms.Compose([
    transforms.Resize((IMAGE_SIZE, IMAGE_SIZE)),
    transforms.ToTensor(),
    transforms.Normalize(mean=[0.485, 0.456, 0.406], std=[0.229, 0.224, 0.225])
])

@app.route("/predict", methods=["POST"])
def predict():
    if model is None:
        return jsonify({"error": "Model tidak berhasil dimuat atau tidak tersedia."}), 500
    if 'file' not in request.files:
        return jsonify({"error": "Tidak ada file gambar yang diunggah"}), 400

    file = request.files['file']
    try:
        image = Image.open(file.stream).convert('RGB')
        
        # Preprocessing gambar
        input_tensor = preprocess_transform(image).unsqueeze(0).to(device)
        
        with torch.no_grad():
            output = model(input_tensor)
            probabilities = torch.nn.functional.softmax(output[0], dim=0)
            confidence, predicted_idx = torch.max(probabilities, 0)

        predicted_class = CLASS_NAMES[predicted_idx.item()]
        confidence_percent = confidence.item() * 100
        info = INFO_PENYAKIT.get(predicted_class)
        
        return jsonify({
            "prediksi": predicted_class,
            "kepercayaan": f"{confidence_percent:.2f}%",
            "deskripsi": info['deskripsi'],
            "saran": info['saran']
        })
    except Exception as e:
        return jsonify({"error": f"Terjadi kesalahan saat prediksi: {str(e)}"}), 500

if __name__ == "__main__":
    if model is not None:
        app.run(host="0.0.0.0", port=5000)
    else:
        print("API tidak dapat dijalankan karena model gagal dimuat.")