<x-layout>
    <div class="space-y-12">
        <section class="text-center" data-aos="fade-down">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-blue-900 mb-2">Hasil dan Evaluasi Model</h2>
            <p class="max-w-3xl mx-auto text-lg text-slate-600">
                Berikut adalah rincian performa dari model AI Dr. Sawit yang telah dilatih.
            </p>
        </section>

        <section>
            <h3 class="text-3xl font-bold text-slate-800 mb-8 text-center" data-aos="fade-up">Visualisasi Tren Pelatihan</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-5 rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="text-xl font-semibold text-center text-blue-800 mb-4">Grafik Akurasi</h4>
                    <img src="{{ asset('images/grafik_akurasi.png') }}" alt="Grafik Akurasi" class="w-full rounded-md border">
                </div>
                <div class="bg-white p-5 rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="text-xl font-semibold text-center text-blue-800 mb-4">Grafik Loss</h4>
                    <img src="{{ asset('images/grafik_loss.png') }}" alt="Grafik Loss" class="w-full rounded-md border">
                </div>
            </div>
        </section>
        
        <section>
             <h3 class="text-3xl font-bold text-slate-800 mb-8 text-center" data-aos="fade-up">Laporan Performa Model</h3>
             <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 items-start">
                <div class="bg-white p-5 rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="text-xl font-semibold text-center text-blue-800 mb-4">Confusion Matrix</h4>
                    <div class="flex justify-center">
                         <img src="{{ asset('images/confusion_matrix.png') }}" alt="Confusion Matrix" class="w-full max-w-md rounded-md border">
                    </div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="text-xl font-semibold text-center text-blue-800 mb-4">Classification Report</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Kelas</th>
                                    <th scope="col" class="py-3 px-6 text-center">Precision</th>
                                    <th scope="col" class="py-3 px-6 text-center">Recall</th>
                                    <th scope="col" class="py-3 px-6 text-center">F1-Score</th>
                                    <th scope="col" class="py-3 px-6 text-center">Support</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b">
                                    <td class="py-4 px-6 font-medium text-gray-900">daun_sehat</td>
                                    <td class="py-4 px-6 text-center">1.0000</td>
                                    <td class="py-4 px-6 text-center">0.9900</td>
                                    <td class="py-4 px-6 text-center">0.9950</td>
                                    <td class="py-4 px-6 text-center">100</td>
                                </tr>
                                <tr class="bg-gray-50 border-b">
                                    <td class="py-4 px-6 font-medium text-gray-900">daun_kuning</td>
                                    <td class="py-4 px-6 text-center">0.9901</td>
                                    <td class="py-4 px-6 text-center">1.0000</td>
                                    <td class="py-4 px-6 text-center">0.9950</td>
                                    <td class="py-4 px-6 text-center">100</td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <td class="py-4 px-6 font-medium text-gray-900">daun_bercak</td>
                                    <td class="py-4 px-6 text-center">1.0000</td>
                                    <td class="py-4 px-6 text-center">1.0000</td>
                                    <td class="py-4 px-6 text-center">1.0000</td>
                                    <td class="py-4 px-6 text-center">100</td>
                                </tr>
                                 <tr class="bg-gray-50 border-b">
                                    <td class="py-4 px-6 font-medium text-gray-900">daun_busuk</td>
                                    <td class="py-4 px-6 text-center">1.0000</td>
                                    <td class="py-4 px-6 text-center">1.0000</td>
                                    <td class="py-4 px-6 text-center">1.0000</td>
                                    <td class="py-4 px-6 text-center">100</td>
                                </tr>
                            </tbody>
                            <tfoot class="font-semibold text-gray-900">
                                <tr class="bg-white border-t-2">
                                    <td class="py-3 px-6">Accuracy</td>
                                    <td class="py-3 px-6"></td>
                                    <td class="py-3 px-6"></td>
                                    <td class="py-3 px-6 text-center">0.9975</td>
                                    <td class="py-3 px-6 text-center">400</td>
                                </tr>
                                 <tr class="bg-gray-50">
                                    <td class="py-3 px-6">Macro Avg</td>
                                    <td class="py-3 px-6 text-center">0.9975</td>
                                    <td class="py-3 px-6 text-center">0.9975</td>
                                    <td class="py-3 px-6 text-center">0.9975</td>
                                    <td class="py-3 px-6 text-center">400</td>
                                </tr>
                                 <tr class="bg-white">
                                    <td class="py-3 px-6">Weighted Avg</td>
                                    <td class="py-3 px-6 text-center">0.9975</td>
                                    <td class="py-3 px-6 text-center">0.9975</td>
                                    <td class="py-3 px-6 text-center">0.9975</td>
                                    <td class="py-3 px-6 text-center">400</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layout>