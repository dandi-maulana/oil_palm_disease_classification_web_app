<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Deteksi Penyakit Daun Kelapa Sawit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .loader { border-top-color: #3498db; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-gray-100 font-sans flex flex-col min-h-screen">

    <header class="bg-white shadow-md sticky top-0 z-50">
        {{-- Menambahkan class 'sticky top-0 z-50' membuat header tetap di atas --}}
        <div class="container mx-auto px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-800">🌱 Sistem Deteksi Penyakit Daun Kelapa Sawit</h1>
            <p class="text-gray-600">Unggah gambar untuk mengetahui kondisi daun kelapa sawit Anda secara cepat.</p>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-6 py-8">
        {{ $slot }}
        {{-- Variabel $slot akan diisi oleh konten dari halaman yang menggunakan layout ini --}}
    </main>

    <footer class="bg-white mt-8 py-4 shadow-inner">
        <div class="container mx-auto px-6 text-center text-gray-600 text-sm">
            &copy; 2025 Sistem Cerdas untuk Petani Sawit. Dibuat dengan Laravel & PyTorch.
        </div>
    </footer>

    {{-- Jika ada script khusus untuk halaman tertentu, bisa diletakkan di sini --}}
    @isset($script)
        {{ $script }}
    @endisset

</body>
</html>