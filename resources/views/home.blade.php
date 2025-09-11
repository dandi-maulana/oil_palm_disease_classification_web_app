<x-layout>
    <div class="space-y-16">
        <section class="text-center" data-aos="fade-down">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-blue-900 mb-4">Selamat Datang di Dr. Sawit</h2>
            <p class="max-w-3xl mx-auto text-lg text-slate-600">
                Solusi cerdas berbasis AI untuk membantu Anda mendeteksi penyakit daun kelapa sawit secara dini. Bersama Dr. Sawit, jaga kesehatan perkebunan Anda untuk hasil panen yang maksimal.
            </p>
        </section>

        <section class="text-center" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('pengujian') }}" 
               class="inline-block bg-blue-600 text-white font-bold text-lg px-8 py-4 rounded-lg shadow-lg hover:bg-blue-700 transition-transform duration-300 transform hover:scale-105">
                Coba Pengujian Sekarang!
            </a>
        </section>

        <section>
            <h3 class="text-3xl font-bold text-slate-800 mb-8 text-center" data-aos="fade-up">Sampel Data yang Digunakan</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="bg-white p-4 rounded-lg shadow-lg" data-aos="zoom-in" data-aos-delay="100">
                    <img src="{{ asset('images/daun_sehat.jpg') }}" alt="Daun Sehat" class="w-full h-40 object-cover rounded-md mb-3">
                    <h4 class="font-semibold text-blue-800 text-lg">Daun Sehat</h4>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ asset('images/daun_kuning.jpg') }}" alt="Daun Kuning" class="w-full h-40 object-cover rounded-md mb-3">
                    <h4 class="font-semibold text-blue-800 text-lg">Daun Kuning</h4>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg" data-aos="zoom-in" data-aos-delay="300">
                    <img src="{{ asset('images/daun_bercak.jpg') }}" alt="Daun Bercak" class="w-full h-40 object-cover rounded-md mb-3">
                    <h4 class="font-semibold text-blue-800 text-lg">Daun Bercak</h4>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg" data-aos="zoom-in" data-aos-delay="400">
                    <img src="{{ asset('images/daun_busuk.jpg') }}" alt="Daun Busuk" class="w-full h-40 object-cover rounded-md mb-3">
                    <h4 class="font-semibold text-blue-800 text-lg">Daun Busuk</h4>
                </div>
            </div>
        </section>

        <section>
            <h3 class="text-3xl font-bold text-slate-800 mb-8 text-center" data-aos="fade-up">Dokumentasi Pengambilan Dataset</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{ asset('images/dokumentasi01.jpeg') }}" alt="Dokumentasi Daun Sehat" class="w-full h-56 object-cover">
                    <div class="p-5">
                        <p class="text-slate-700">Pengumpulan data daun sehat sebagai data pembanding (kontrol) untuk memastikan model dapat mengenali kondisi normal.</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="200">
                    <img src="{{ asset('images/dokumentasi02.jpeg') }}" alt="Dokumentasi Daun Bercak" class="w-full h-56 object-cover">
                    <div class="p-5">
                        <p class="text-slate-700">Pengambilan sampel di berbagai lokasi, fokus pada daun dengan gejala awal bercak akibat infeksi jamur.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layout>