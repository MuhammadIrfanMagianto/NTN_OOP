<?php
// View/products.php
// View halaman produk (data produk diambil lewat fetch ke api_products.php).
?>
<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NTN PRODUCTS - Retail Collection</title>
    <link rel="icon" type="image/png" href="src/gambar/favicon.png">
    <link href="./output.css" rel="stylesheet"> 
</head>
<body class="font-primary antialiased bg-gray-900 text-gray-100">

    <header>
        <nav class="shadow-xl fixed w-full z-10 border-b border-gray-700"
             style="background-color: rgba(18, 28, 40, 0.7); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
            
            <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
                
                <a href="index.php" class="flex items-center">
                    <img src="src/gambar/logo.png" alt="NTN INDUSTRIES Logo" class="h-8 lg:h-12">
                </a>
                
                <div class="hidden lg:flex flex-grow items-center justify-end">
                    <ul class="flex space-x-8 text-lg font-medium">
                        <!-- <li><a href="index.php" class="text-gray-300 hover:text-secondary transition">Home</a></li> -->
                        <!-- <li><a href="index.php#services" class="text-gray-300 hover:text-secondary transition">Layanan</a></li> -->
                        <!-- <li><a href="index.php#contact" class="text-gray-300 hover:text-secondary transition">Kontak</a></li> -->
                    </ul>
                    <a href="index.php#register" class="text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105"
                       style="background-color: rgba(74, 144, 226, 0.6); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.5);">
                        Kembali
                    </a>
                    <a href="auth.php?logout=1" class="text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105"
                       style="margin-left: 1rem; background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
                        Logout
                    </a>
                </div>
                
                <div class="lg:hidden" style="display: flex; gap: 0.5rem;">
                    <a href="index.php#register" class="text-white font-semibold py-2 px-3 text-sm rounded-lg transition transform hover:scale-105"
                       style="background-color: rgba(74, 144, 226, 0.6); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.5);">
                        Kembali
                    </a>
                    <a href="auth.php?logout=1" class="text-white font-semibold py-2 px-3 text-sm rounded-lg transition transform hover:scale-105"
                       style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
                        Logout
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="bg-gray-900 pt-32 lg:pt-40 pb-16 min-h-screen">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-white mb-4">Koleksi NTN Gang Terbaru</h1>
            <!-- <p class="text-lg text-gray-400 mb-8">Data harga dan nama produk diambil secara dinamis menggunakan Fetch API (FakeStore).</p> -->

            <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <p class="text-secondary col-span-full">Memuat produk...</p>
            </div>
        </div>
    </main>

    <footer class="text-white py-10"
            style="background-color: rgba(18, 28, 40, 0.7); backdrop-filter: blur(10px); border-top: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-sm text-gray-500">&copy; 2025 NTN INDUSTRIES. All rights reserved.</p>
        </div>
    </footer>
    
        <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const productList = document.getElementById('product-list');
                    // GANTI API URL DENGAN ENDPOINT LOKAL ANDA SENDIRI
                    const apiURL = './api_products.php'; 

                    fetch(apiURL)
                        .then(res => res.json())
                        .then(data => {
                            productList.innerHTML = '';
                            
                            data.forEach((product, index) => {
                                
                                // Gunakan gambar dari data JSON jika ada, jika tidak gunakan fallback
                                const imagePath = product.image || 'src/gambar/logo.png';
                                
                                const productCard = `
                                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl transition transform hover:scale-[1.03]">
                                        <div class="h-64 flex items-center justify-center bg-gray-700/50 p-4">
                                            <img src="${imagePath}" alt="${product.title}" class="h-full max-w-full object-contain">
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold text-white truncate">${product.title}</h3>
                                            <p class="text-secondary font-bold text-xl mt-1">Rp ${product.price.toLocaleString('id-ID')}</p>
                                            <p class="text-xs text-gray-400 mt-2">${product.category}</p>
                                            <button class="w-full bg-secondary text-primary font-bold mt-4 py-2 rounded-lg transition hover:bg-[#3d7ed4]">
                                                Beli Sekarang
                                            </button>
                                        </div>
                                    </div>
                                `;
                                productList.innerHTML += productCard;
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching products:', error);
                            productList.innerHTML = '<p class="text-red-500 col-span-full">❌ Gagal memuat koleksi produk dari API lokal.</p>';
                        });
                });
            </script>

</body>
</html>