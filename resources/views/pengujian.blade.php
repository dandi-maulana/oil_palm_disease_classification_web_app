<x-layout>
    {{-- Halaman Pengujian dengan Modal --}}
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto" data-aos="fade-in">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-blue-900">Uji Model Dr. Sawit</h2>
            <p class="text-slate-600">Silakan unggah foto daun kelapa sawit untuk memulai analisis.</p>
        </div>

        {{-- Form hanya berisi tombol untuk memicu pemilihan file --}}
        <div class="text-center">
            <label for="gambar-input" class="cursor-pointer inline-block bg-blue-600 text-white font-bold text-lg px-8 py-4 rounded-lg shadow-lg hover:bg-blue-700 transition-transform duration-300 transform hover:scale-105">
                Pilih Gambar Daun
            </label>
            <input id="gambar-input" type="file" name="gambar_sawit" class="hidden" accept="image/jpeg, image/png, image/jpg">
        </div>

        {{-- Area Hasil (akan diisi setelah analisis) --}}
        <div id="result-area" class="mt-8 hidden">
            <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">Hasil Analisis Terakhir</h3>
             <div class="bg-blue-50 p-4 rounded-lg shadow-inner">
                <div id="result-content" class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-full md:w-1/3">
                        <img id="final-image" src="#" alt="Gambar Final" class="rounded-lg shadow-md w-full">
                    </div>
                    <div class="w-full md:w-2/3">
                        <div id="prediction-output" class="p-4 rounded-lg">
                            <p class="text-2xl font-bold" id="hasil-prediksi"></p>
                            <p class="text-gray-600" id="hasil-kepercayaan"></p>
                        </div>
                        <div class="mt-4 space-y-2 text-sm text-slate-700">
                            <p><strong>Waktu Selesai:</strong> <span id="waktu-selesai"></span></p>
                            <p><strong>Durasi Analisis:</strong> <span id="durasi-analisis"></span></p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 border-t pt-4">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">💡 Informasi & Saran</h4>
                    <p class="text-gray-700 mb-2" id="hasil-deskripsi"></p>
                    <p class="text-gray-700 font-semibold" id="hasil-saran"></p>
                </div>
            </div>
        </div>
        
         <div id="error-area" class="hidden mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <strong class="font-bold">Terjadi Kesalahan!</strong>
            <span class="block sm:inline" id="error-message"></span>
        </div>
    </div>

    <div id="preview-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-full overflow-y-auto p-6"  x-data="{ open: true }" x-show="open" @click.away="open = false; document.getElementById('preview-modal').classList.add('hidden')">
            <h3 class="text-2xl font-bold text-blue-900 mb-4">Konfirmasi Pengujian</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-slate-700 mb-2">Preview Gambar:</h4>
                    <img id="preview-image" src="#" alt="Preview Gambar" class="rounded-lg shadow-md w-full">
                </div>
                <div class="space-y-3 text-slate-800">
                    <h4 class="font-semibold text-slate-700 mb-2">Detail Pengujian:</h4>
                    <div>
                        <p class="font-bold">Tim Pengembang:</p>
                        <p class="text-sm">Nugraha R.D, Stevi F.S, M.Rizky A.H</p>
                    </div>
                     <div>
                        <p class="font-bold">Dosen Pembimbing:</p>
                        <p class="text-sm">Muhathir, S.T., M.Kom</p>
                    </div>
                    <div>
                        <p class="font-bold">Lokasi Dataset:</p>
                        <p class="text-sm">Desa Sei-Simujur, Kec. Laut Tador, Kab. Batu Bara, Sumatera Utara.</p>
                    </div>
                    <div>
                        <p class="font-bold">Model AI:</p>
                        <p class="text-sm">Arsitektur Squeezenet dengan Grup Convolution</p>
                    </div>
                    <div>
                        <p class="font-bold">Waktu Pengujian:</p>
                        <p class="text-sm" id="modal-waktu"></p>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-4">
                <button id="cancel-button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg">Batal</button>
                <button id="confirm-button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg flex items-center">
                    <span id="button-text">Analisis Sekarang</span>
                    <div id="modal-loader" class="hidden w-5 h-5 ml-3 border-2 border-white border-t-transparent rounded-full loader"></div>
                </button>
            </div>
        </div>
    </div>

    <x-slot:script>
        <script>
            // Elemen-elemen DOM
            const fileInput = document.getElementById('gambar-input');
            const modal = document.getElementById('preview-modal');
            const previewImage = document.getElementById('preview-image');
            const modalTime = document.getElementById('modal-waktu');
            const cancelButton = document.getElementById('cancel-button');
            const confirmButton = document.getElementById('confirm-button');
            const modalLoader = document.getElementById('modal-loader');
            const buttonText = document.getElementById('button-text');

            const resultArea = document.getElementById('result-area');
            const resultContent = document.getElementById('result-content');
            const errorArea = document.getElementById('error-area');
            const errorMessage = document.getElementById('error-message');
            
            let selectedFile = null;
            let beforeTime = null;

            // Event listener untuk input file
            fileInput.addEventListener('change', (e) => {
                if (e.target.files && e.target.files[0]) {
                    selectedFile = e.target.files[0];
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        previewImage.src = event.target.result;
                    }
                    reader.readAsDataURL(selectedFile);
                    
                    // Format waktu Indonesia
                    beforeTime = new Date();
                    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'Asia/Jakarta' };
                    modalTime.textContent = beforeTime.toLocaleDateString('id-ID', options);
                    
                    modal.classList.remove('hidden');
                }
            });

            // Fungsi untuk menutup modal
            function closeModal() {
                modal.classList.add('hidden');
                fileInput.value = ''; // Reset input file
                selectedFile = null;
                beforeTime = null;
                confirmButton.disabled = false;
                modalLoader.classList.add('hidden');
                buttonText.textContent = 'Analisis Sekarang';
            }

            cancelButton.addEventListener('click', closeModal);

            // Event listener untuk tombol konfirmasi analisis
            confirmButton.addEventListener('click', async () => {
                if (!selectedFile || !beforeTime) return;

                // Tampilkan loading di tombol
                confirmButton.disabled = true;
                modalLoader.classList.remove('hidden');
                buttonText.textContent = 'Menganalisis...';

                resultArea.classList.add('hidden');
                errorArea.classList.add('hidden');

                const formData = new FormData();
                formData.append('gambar_sawit', selectedFile);
                formData.append('waktu_sebelum_uji', beforeTime.toISOString());

                try {
                    const response = await fetch("{{ route('predict') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();
                    
                    if (!response.ok) {
                        throw new Error(data.error || 'Terjadi kesalahan tidak diketahui.');
                    }
                    
                    displayResults(data);

                } catch (error) {
                    displayError(error.message);
                } finally {
                    closeModal();
                }
            });

            function displayResults(data) {
                document.getElementById('final-image').src = previewImage.src;
                document.getElementById('hasil-prediksi').textContent = data.prediksi;
                document.getElementById('hasil-kepercayaan').textContent = `Tingkat Kepercayaan: ${data.kepercayaan}`;
                document.getElementById('hasil-deskripsi').textContent = data.deskripsi;
                document.getElementById('hasil-saran').textContent = `Saran: ${data.saran}`;
                document.getElementById('waktu-selesai').textContent = data.waktu_sesudah_uji;
                document.getElementById('durasi-analisis').textContent = data.durasi;
                
                const outputDiv = document.getElementById('prediction-output');
                const prediksiText = document.getElementById('hasil-prediksi');
    
                outputDiv.className = 'p-4 rounded-lg'; // Reset classes
                prediksiText.className = 'text-2xl font-bold';
    
                if (data.prediksi === 'Daun Sehat') {
                    outputDiv.classList.add('bg-green-100');
                    prediksiText.classList.add('text-green-800');
                } else {
                    outputDiv.classList.add('bg-red-100');
                    prediksiText.classList.add('text-red-800');
                }
                
                resultArea.classList.remove('hidden');
            }

            function displayError(message) {
                errorMessage.textContent = message;
                errorArea.classList.remove('hidden');
            }
        </script>
    </x-slot:script>
</x-layout>