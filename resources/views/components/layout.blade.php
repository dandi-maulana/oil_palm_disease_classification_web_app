<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Judul di tab browser diubah --}}
    <title>Dr. Sawit - Deteksi Penyakit Daun Kelapa Sawit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .loader { border-top-color: #3b82f6; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-slate-50 font-sans flex flex-col min-h-screen">

    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <nav x-data="{ open: false }" class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ url('/') }}">
                        <img class="h-12 w-auto" src="{{ asset('images/LOGO_UMA.png') }}" alt="Logo UMA">
                    </a>
                     <a href="{{ url('/') }}">
                        <img class="h-12 w-auto" src="{{ asset('images/gemastik18-secondary.svg') }}" alt="Logo Organisasi">
                    </a>
                </div>

                {{-- ... sisa kode navbar tetap sama ... --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-600' }} pb-1 transition duration-300 hover:text-blue-600">Home</a>
                    <a href="{{ route('hasil') }}" class="{{ request()->is('hasil') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-600' }} pb-1 transition duration-300 hover:text-blue-600">Hasil Model</a>
                    <a href="{{ route('pengujian') }}" class="{{ request()->is('pengujian') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-600' }} pb-1 transition duration-300 hover:text-blue-600">Pengujian</a>
                    <a href="{{ route('riwayat') }}" class="{{ request()->is('riwayat') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-600' }} pb-1 transition duration-300 hover:text-blue-600">Riwayat</a>
                    <a href="{{ route('tentang-kami') }}" class="{{ request()->is('tentang-kami') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-600' }} pb-1 transition duration-300 hover:text-blue-600">Tentang Kami</a>
                </div>
                <div class="md:hidden">
                    <button @click="open = !open" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
            <div :class="{'block': open, 'hidden': !open}" class="md:hidden mt-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-2 text-sm rounded-md {{ request()->is('/') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }} hover:bg-blue-50">Home</a>
                <a href="{{ route('hasil') }}" class="block px-4 py-2 text-sm rounded-md {{ request()->is('hasil') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }} hover:bg-blue-50">Hasil Model</a>
                <a href="{{ route('pengujian') }}" class="block px-4 py-2 text-sm rounded-md {{ request()->is('pengujian') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }} hover:bg-blue-50">Pengujian</a>
                <a href="{{ route('riwayat') }}" class="block px-4 py-2 text-sm rounded-md {{ request()->is('riwayat') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }} hover:bg-blue-50">Riwayat</a>
                <a href="{{ route('tentang-kami') }}" class="block px-4 py-2 text-sm rounded-md {{ request()->is('tentang-kami') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }} hover:bg-blue-50">Tentang Kami</a>
            </div>
        </nav>
    </header>

    <main class="flex-grow container mx-auto px-6 py-8">
        {{ $slot }}
    </main>

    {{-- Footer Diperbarui --}}
    <footer class="bg-gradient-to-r from-blue-700 to-blue-900 text-white mt-8 pt-8 pb-6 shadow-inner">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-xl font-bold mb-2">Dr. Sawit</h3>
            <p class="text-blue-200 text-sm mb-4">
                Membantu Anda menjaga kesehatan perkebunan kelapa sawit dengan teknologi AI.
            </p>
            
            <div class="flex justify-center items-center space-x-6 mb-4">
                
                <a href="https://www.youtube.com/c/DandiKaslana" target="_blank" title="YouTube" class="text-blue-200 hover:text-white transition-transform duration-300 transform hover:scale-125">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21.582,6.186 C21.328,5.247 20.612,4.532 19.673,4.278 C18.006,3.805 12,3.805 12,3.805 C12,3.805 5.994,3.805 4.327,4.278 C3.388,4.532 2.672,5.247 2.418,6.186 C1.945,7.854 1.945,12 1.945,12 C1.945,12 1.945,16.146 2.418,17.814 C2.672,18.753 3.388,19.468 4.327,19.722 C5.994,20.195 12,20.195 12,20.195 C12,20.195 18.006,20.195 19.673,19.722 C20.612,19.468 21.328,18.753 21.582,17.814 C22.055,16.146 22.055,12 22.055,12 C22.055,12 22.055,7.854 21.582,6.186 Z M9.933,15.006 V8.994 L15.915,12 L9.933,15.006 Z"></path>
                    </svg>
                    <span class="sr-only">YouTube</span>
                </a>

                <a href="https://www.tiktok.com/@dandikaslana/" target="_blank" title="TikTok" class="text-blue-200 hover:text-white transition-transform duration-300 transform hover:scale-125">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-2.43.05-4.84-.95-6.43-2.8-1.59-1.87-2.32-4.2-1.86-6.33.36-1.72 1.47-3.26 2.99-4.13.78-.45 1.6-.74 2.46-.88.02-3.37.01-6.74 0-10.11h4.03c.01 1.66-.01 3.32.01 4.98z"></path>
                    </svg>
                    <span class="sr-only">TikTok</span>
                </a>

                <a href="https://www.instagram.com/dandikaslana/" target="_blank" title="Instagram" class="text-blue-200 hover:text-white transition-transform duration-300 transform hover:scale-125">
                     <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2c-2.717 0-3.056.01-4.122.06-1.065.05-1.79.22-2.428.46-1.29.51-2.22 1.45-2.73 2.73-.24.64-.41 1.36-.46 2.43C2.01 8.94 2 9.28 2 12s.01 3.06.06 4.12c.05 1.07.22 1.79.46 2.43.51 1.29 1.45 2.22 2.73 2.73.64.24 1.36.41 2.43.46 1.06.05 1.4.06 4.12.06s3.06-.01 4.12-.06c1.07-.05 1.79-.22 2.43-.46 1.29-.51 2.22-1.45 2.73-2.73.24-.64.41-1.36.46-2.43.05-1.06.06-1.4.06-4.12s-.01-3.06-.06-4.12c-.05-1.07-.22-1.79-.46-2.43-.51-1.29-1.45-2.22-2.73-2.73-.64-.24-1.36-.41-2.43-.46C15.06 2.01 14.72 2 12 2zm0 1.8c2.649 0 2.951.01 3.985.06 1.018.05 1.58.21 1.94.37.56.26.96.66 1.22 1.22.16.36.32.92.37 1.94.05 1.03.06 1.34.06 3.99s-.01 2.96-.06 3.99c-.05 1.02-.21 1.58-.37 1.94-.26.56-.66.96-1.22 1.22-.36.16-.92.32-1.94.37-1.03.05-1.34.06-3.99.06s-2.96-.01-3.99-.06c-1.02-.05-1.58-.21-1.94-.37-.56-.26-.96-.66-1.22-1.22-.16-.36-.32-.92-.37-1.94-.05-1.03-.06-1.34-.06-3.99s.01-2.96.06-3.99c.05-1.02.21-1.58.37-1.94.26-.56.66-.96 1.22-1.22.36-.16.92-.32 1.94-.37C9.05 3.81 9.35 3.8 12 3.8zm0 3.35c-2.485 0-4.485 2-4.485 4.485s2 4.485 4.485 4.485 4.485-2 4.485-4.485-2-4.485-4.485-4.485zm0 7.17c-1.48 0-2.685-1.205-2.685-2.685s1.205-2.685 2.685-2.685 2.685 1.205 2.685 2.685-1.205 2.685-2.685 2.685zm4.805-7.82c-.63 0-1.14.51-1.14 1.14s.51 1.14 1.14 1.14 1.14-.51 1.14-1.14-.51-1.14-1.14-1.14z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Instagram</span>
                </a>

                <a href="https://github.com/dandi-maulana" target="_blank" title="GitHub" class="text-blue-200 hover:text-white transition-transform duration-300 transform hover:scale-125">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.165 6.837 9.489.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.031-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.03 1.595 1.03 2.688 0 3.848-2.338 4.695-4.566 4.942.359.308.678.92.678 1.852 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.001 10.001 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">GitHub</span>
                </a>
            </div>
            <div class="mt-6 border-t border-blue-600 pt-4">
                <p>Dibuat dan dikembangkan oleh Tim ANUGRAH &copy; 2025</p>
            </div>
        </div>
    </footer>
    {{-- ... sisa kode layout tetap sama ... --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>
    @isset($script)
        {{ $script }}
    @endisset
</body>
</html>