<x-layout>
    {{-- Bagian Konten Utama untuk Halaman Pengujian --}}
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl mx-auto" data-aos="fade-in">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-blue-900">Uji Model Dr. Sawit</h2>
            <p class="text-slate-600">Silakan unggah foto daun kelapa sawit untuk memulai analisis.</p>
        </div>

        <form id="upload-form">
            <div class="mb-5">
                <label for="gambar-input" class="block text-gray-700 text-sm font-bold mb-2">Pilih File Gambar:</label>
                <input id="gambar-input" type="file" name="gambar_sawit" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/jpeg, image/png, image/jpg" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                Analisis Gambar
            </button>
        </form>

        <div id="result-area" class="mt-8 hidden">
            <div id="loader" class="hidden w-12 h-12 mb-4 rounded-full loader mx-auto"></div>
            
            <div id="result-content" class="hidden">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-full md:w-1/2">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Gambar Anda:</h3>
                        <img id="preview-image" src="#" alt="Preview Gambar" class="rounded-lg shadow-md w-full">
                    </div>
                    <div class="w-full md:w-1/2">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Hasil Analisis:</h3>
                        <div id="prediction-output" class="p-4 rounded-lg">
                            <p class="text-2xl font-bold" id="hasil-prediksi"></p>
                            <p class="text-gray-600" id="hasil-kepercayaan"></p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">💡 Informasi & Saran untuk Anda</h3>
                    <p class="text-gray-700 mb-2" id="hasil-deskripsi"></p>
                    <p class="text-gray-700 font-semibold" id="hasil-saran"></p>
                </div>
            </div>
        </div>
        
         <div id="error-area" class="hidden mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-2xl mx-auto">
            <strong class="font-bold">Terjadi Kesalahan!</strong>
            <span class="block sm:inline" id="error-message"></span>
        </div>
    </div>

    {{-- Kode JavaScript untuk halaman ini --}}
    <x-slot:script>
        <script>
            const form = document.getElementById('upload-form');
            const fileInput = document.getElementById('gambar-input');
            const resultArea = document.getElementById('result-area');
            const loader = document.getElementById('loader');
            const resultContent = document.getElementById('result-content');
            const errorArea = document.getElementById('error-area');
            const errorMessage = document.getElementById('error-message');
    
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
    
                if (fileInput.files.length === 0) {
                    alert('Mohon pilih file gambar terlebih dahulu.');
                    return;
                }
    
                resultArea.classList.remove('hidden');
                loader.classList.remove('hidden');
                resultContent.classList.add('hidden');
                errorArea.classList.add('hidden');
    
                const formData = new FormData();
                formData.append('gambar_sawit', fileInput.files[0]);
    
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
                    
                    displayResults(data, fileInput.files[0]);
    
                } catch (error) {
                    displayError(error.message);
                } finally {
                    loader.classList.add('hidden');
                }
            });
    
            function displayResults(data, file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(file);
    
                document.getElementById('hasil-prediksi').textContent = data.prediksi;
                document.getElementById('hasil-kepercayaan').textContent = `Tingkat Kepercayaan: ${data.kepercayaan}`;
                document.getElementById('hasil-deskripsi').textContent = data.deskripsi;
                document.getElementById('hasil-saran').textContent = `Saran: ${data.saran}`;
                
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
    
                resultContent.classList.remove('hidden');
            }
    
            function displayError(message) {
                errorMessage.textContent = message;
                errorArea.classList.remove('hidden');
            }
        </script>
    </x-slot:script>
</x-layout>