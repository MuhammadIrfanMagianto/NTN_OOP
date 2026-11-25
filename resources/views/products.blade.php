<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NTN PRODUCTS - Retail Collection</title>
    <link rel="icon" type="image/png" href="{{ asset('src/gambar/favicon.png') }}">
    <link href="{{ asset('output.css') }}" rel="stylesheet">
</head>
<body class="font-primary antialiased bg-gray-900 text-gray-100">

    <header>
        <nav class="shadow-xl fixed w-full z-10 border-b border-gray-700"
             style="background-color: rgba(18, 28, 40, 0.7); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">

            <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">

                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('src/gambar/logo.png') }}" alt="NTN INDUSTRIES Logo" class="h-8 lg:h-12">
                </a>

                <div class="hidden lg:flex flex-grow items-center justify-end">
                    <ul class="flex space-x-8 text-lg font-medium">
                        <!-- <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-secondary transition">Home</a></li> -->
                        <!-- <li><a href="index.php#services" class="text-gray-300 hover:text-secondary transition">Layanan</a></li> -->
                        <!-- <li><a href="index.php#contact" class="text-gray-300 hover:text-secondary transition">Kontak</a></li> -->
                    </ul>
                    <a href="{{ route('home') }}#register" class="text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105"
                       style="background-color: rgba(74, 144, 226, 0.6); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.5);">
                        Kembali
                    </a>
                    <a href="{{ route('logout') }}" class="text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105"
                       style="margin-left: 1rem; background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
                        Logout
                    </a>
                </div>

            </div>
        </nav>
    </header>

    <main class="bg-gray-900 pt-32 lg:pt-40 pb-16 min-h-screen">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-white mb-4">Koleksi NTN Gang Terbaru</h1>

            <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($products as $product)
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl transition transform hover:scale-[1.03]">
                        <div class="h-64 flex items-center justify-center bg-gray-700/50 p-4">
                            <img src="{{ asset(ltrim($product->gambar ?: 'src/gambar/logo.png', '/')) }}"
                                 alt="{{ $product->nama }}"
                                 class="h-full max-w-full object-contain">
                        </div>
                        <div class="p-4">
                            <span class="text-xs uppercase tracking-wider text-secondary font-semibold">{{ $product->kategori }}</span>
                            <h3 class="text-lg font-semibold text-white truncate mt-1">{{ $product->nama }}</h3>
                            <p class="text-secondary font-bold text-xl mt-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400 mt-2 line-clamp-2">{{ $product->deskripsi }}</p>
                            <button class="w-full bg-secondary text-primary font-bold mt-4 py-2 rounded-lg transition hover:bg-[#3d7ed4]">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 col-span-full">Belum ada produk tersedia.</p>
                @endforelse
            </div>
        </div>
    </main>

    <footer class="text-white py-10"
            style="background-color: rgba(18, 28, 40, 0.7); backdrop-filter: blur(10px); border-top: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-sm text-gray-500">© 2025 NTN INDUSTRIES. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
