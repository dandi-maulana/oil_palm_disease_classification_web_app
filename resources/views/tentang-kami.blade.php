<x-layout>
    <div class="space-y-12">
        <section class="text-center" data-aos="fade-down">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-blue-900 mb-2">Tentang Tim ANUGRAH</h2>
            <p class="max-w-3xl mx-auto text-lg text-slate-600">
                Kami adalah tim yang berdedikasi untuk memberdayakan petani kelapa sawit melalui teknologi AI. Misi kami adalah menyediakan alat bantu yang mudah digunakan, akurat, dan dapat diandalkan untuk deteksi penyakit daun secara dini, demi menjaga produktivitas dan keberlanjutan perkebunan.
            </p>
        </section>

        <section>
            <h3 class="text-3xl font-bold text-slate-800 mb-8 text-center" data-aos="fade-up">Dosen Pembimbing</h3>
            <div class="flex justify-center" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white text-center p-6 rounded-lg shadow-lg w-full max-w-xs transform hover:scale-105 transition-transform duration-300">
                    {{-- Ganti dengan path foto dosen Anda --}}
                    <img class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-blue-200" src="{{ asset('images/pembimbing.jpeg') }}" alt="Foto Dosen Pembimbing">
                    <h4 class="text-xl font-bold text-blue-900">Muhathir, S.T., M.Kom</h4>
                    <p class="text-slate-600">Dosen Pembimbing</p>
                    <p class="text-sm text-slate-500 mt-2">Dosen S1 Teknik Informatika</p>
                </div>
            </div>
        </section>

        <section>
            <h3 class="text-3xl font-bold text-slate-800 mb-8 text-center" data-aos="fade-up">Tim Pengembang</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                
                <div class="bg-white text-center p-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="100">
                    {{-- Ganti dengan path foto ketua --}}
                    <img class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-blue-200" src="{{ asset('images/ketua.jpeg') }}" alt="Foto Ketua Tim">
                    <h4 class="text-xl font-bold text-blue-900">Nugraha Rahmadan Diyanto</h4>
                    <p class="text-slate-600">Ketua Tim</p>
                    <p class="text-sm text-slate-500 mt-2">Mahasiswa S1 Teknik Informatika</p>
                </div>

                <div class="bg-white text-center p-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="200">
                    {{-- Ganti dengan path foto anggota 1 --}}
                    <img class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-blue-200" src="{{ asset('images/anggota1.jpeg') }}" alt="Foto Anggota Tim 1">
                    <h4 class="text-xl font-bold text-blue-900">Stevi Freshia Sihombing</h4>
                    <p class="text-slate-600">Anggota</p>
                    <p class="text-sm text-slate-500 mt-2">Mahasiswi S1 Teknik Informatika</p>
                </div>

                <div class="bg-white text-center p-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="300">
                    {{-- Ganti dengan path foto anggota 2 --}}
                    <img class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-blue-200" src="{{ asset('images/anggota2.jpeg') }}" alt="Foto Anggota Tim 2">
                    <h4 class="text-xl font-bold text-blue-900">M.Rizky Aulia Hrp</h4>
                    <p class="text-slate-600">Anggota</p>
                    <p class="text-sm text-slate-500 mt-2">Mahasiswa S1 Teknik Informatika</p>
                </div>

            </div>
        </section>
    </div>
</x-layout>