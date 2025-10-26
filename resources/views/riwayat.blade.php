<x-layout>
    <div class="space-y-12">
        <section class="text-center" data-aos="fade-down">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-blue-900 mb-2">Riwayat Pengujian</h2>
            <p class="max-w-3xl mx-auto text-lg text-slate-600">
                Berikut adalah daftar semua analisis yang telah dilakukan oleh sistem Dr. Sawit.
            </p>
        </section>

        <section data-aos="fade-up">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-5xl mx-auto">
                
                <form action="{{ route('riwayat') }}" method="GET" class="mb-6">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari berdasarkan hasil atau nama file..."
                               value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="absolute top-0 left-0 inline-flex items-center p-2">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </form>

                <div class="space-y-4">
                    @forelse ($riwayat as $item)
                        {{-- DATA BARU DITAMBAHKAN DI SINI --}}
                        <div class="riwayat-card bg-slate-50 border rounded-lg p-4 flex items-center space-x-4 cursor-pointer hover:bg-blue-100 transition duration-300"
                             data-gambar="{{ Storage::url($item->gambar_path) }}"
                             data-hasil="{{ $item->hasil_prediksi }}"
                             data-kepercayaan="{{ $item->kepercayaan }}"
                             data-model="{{ $item->model_ai }}"
                             data-lokasi="{{ $item->lokasi_dataset }}"
                             data-waktu="{{ \Carbon\Carbon::parse($item->waktu_sesudah_uji)->translatedFormat('d F Y, H:i:s') }}"
                             data-durasi="{{ number_format($item->durasi_pengujian, 4) }} detik"
                             data-file="{{ $item->nama_file }}"
                             data-penguji="{{ $item->nama_penguji }}"
                             data-lokasi-pengujian="{{ $item->lokasi_pengujian }}">
                            
                            <img src="{{ Storage::url($item->gambar_path) }}" alt="Preview {{ $item->nama_file }}" class="w-20 h-20 object-cover rounded-md shadow-sm">
                            
                            <div class="flex-grow">
                                <p class="text-lg font-bold {{ $item->hasil_prediksi == 'Daun Sehat' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item->hasil_prediksi }}
                                </p>
                                <p class="text-sm text-gray-600">Kepercayaan: {{ $item->kepercayaan }}</p>
                                {{-- INFO PENGUJI DITAMBAHKAN DI KARTU --}}
                                <p class="text-xs text-gray-500 mt-1">Diuji oleh: <strong>{{ $item->nama_penguji }}</strong></p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($item->waktu_sesudah_uji)->diffForHumans() }}
                                </p>
                            </div>
                            
                            <div class="text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Hasil Tidak Ditemukan</h3>
                            <p class="mt-1 text-sm text-gray-500">Tidak ada riwayat yang cocok dengan kata kunci "{{ request('search') }}".</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $riwayat->appends(request()->query())->links() }}
                </div>
            </div>
        </section>
    </div>

    <div id="detail-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div id="modal-content" class="bg-white rounded-lg shadow-2xl w-full max-w-3xl max-h-full overflow-y-auto p-6 relative">
            <button id="close-modal-button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h3 class="text-2xl font-bold text-blue-900 mb-4">Detail Riwayat Analisis</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <img id="modal-gambar" src="" alt="Gambar Detail" class="rounded-lg shadow-md w-full">
                </div>
                {{-- DETAIL MODAL DIPERBARUI DI SINI --}}
                <div class="space-y-3 text-slate-800">
                     <div>
                        <p class="font-bold">Hasil Prediksi:</p>
                        <p class="text-xl font-semibold" id="modal-hasil"></p>
                    </div>
                    <div>
                        <p class="font-bold">Tingkat Kepercayaan:</p>
                        <p id="modal-kepercayaan"></p>
                    </div>
                    <div class="border-t my-2"></div>
                    <div>
                        <p class="font-bold">Nama Penguji:</p>
                        <p class="text-sm" id="modal-penguji"></p>
                    </div>
                    <div>
                        <p class="font-bold">Lokasi Pengujian:</p>
                        <p class="text-sm" id="modal-lokasi-pengujian"></p>
                    </div>
                    <div class="border-t my-2"></div>
                    <div>
                        <p class="font-bold">Waktu Analisis:</p>
                        <p class="text-sm" id="modal-waktu"></p>
                    </div>
                     <div>
                        <p class="font-bold">Durasi:</p>
                        <p class="text-sm" id="modal-durasi"></p>
                    </div>
                     <div>
                        <p class="font-bold">Nama File Asli:</p>
                        <p class="text-sm" id="modal-file"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <x-slot:script>
        <script>
            const modal = document.getElementById('detail-modal');
            const modalContent = document.getElementById('modal-content');
            const closeModalButton = document.getElementById('close-modal-button');
            const riwayatCards = document.querySelectorAll('.riwayat-card');

            function showModal(data) {
                document.getElementById('modal-gambar').src = data.gambar;
                document.getElementById('modal-hasil').textContent = data.hasil;
                document.getElementById('modal-kepercayaan').textContent = data.kepercayaan;
                document.getElementById('modal-waktu').textContent = data.waktu;
                document.getElementById('modal-durasi').textContent = data.durasi;
                document.getElementById('modal-file').textContent = data.file;
                
                // === JAVASCRIPT DIPERBARUI DI SINI ===
                document.getElementById('modal-penguji').textContent = data.penguji;
                document.getElementById('modal-lokasi-pengujian').textContent = data.lokasi_pengujian;
                
                const hasilText = document.getElementById('modal-hasil');
                hasilText.classList.remove('text-green-600', 'text-red-600');
                if (data.hasil === 'Daun Sehat') {
                    hasilText.classList.add('text-green-600');
                } else {
                    hasilText.classList.add('text-red-600');
                }

                modal.classList.remove('hidden');
            }
            
            function closeModal() {
                modal.classList.add('hidden');
            }

            riwayatCards.forEach(card => {
                card.addEventListener('click', () => {
                    const data = {
                        gambar: card.dataset.gambar,
                        hasil: card.dataset.hasil,
                        kepercayaan: card.dataset.kepercayaan,
                        model: card.dataset.model,
                        lokasi: card.dataset.lokasi,
                        waktu: card.dataset.waktu,
                        durasi: card.dataset.durasi,
                        file: card.dataset.file,
                        // === DATA BARU DIAMBIL DARI KARTU ===
                        penguji: card.dataset.penguji,
                        lokasi_pengujian: card.dataset.lokasiPengujian, // perhatikan camelCase
                    };
                    showModal(data);
                });
            });

            closeModalButton.addEventListener('click', closeModal);
            
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
        </script>
    </x-slot:script>
</x-layout>