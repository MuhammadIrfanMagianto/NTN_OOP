<?php
// View/home.php
// View hanya menampilkan data yang dikirim Controller ($data) -- tanpa membuat object/logika data.
$tshirt       = $data['tshirt'];
$hoodie       = $data['hoodie'];
$jasaKonveksi = $data['jasaKonveksi'];
$jasaPolo     = $data['jasaPolo'];
$isLoggedIn    = $data['isLoggedIn'];
$username      = $data['username'];
?>
<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NTN INDUSTRIES</title>
    <link rel="icon" type="image/png" href="src/gambar/favicon.png">
    <link href="./output.css" rel="stylesheet"> 
    
    <style>
        @keyframes cinematic-hue-shift {
          0% { box-shadow: 0 0 40px rgba(18, 28, 40, 0.8), 0 0 15px rgba(0, 100, 200, 0.5); }
          50% { box-shadow: 0 0 70px rgba(74, 144, 226, 0.7), 0 0 30px rgba(255, 255, 255, 0.4); }
          100% { box-shadow: 0 0 40px rgba(18, 28, 40, 0.8), 0 0 15px rgba(0, 100, 200, 0.5); }
        }
        .cinematic-box { animation: cinematic-hue-shift 6s infinite alternate ease-in-out; }
    </style>
</head>
<body class="font-primary antialiased bg-gray-900 text-gray-100">

    <header>
        <nav class="shadow-xl fixed w-full z-10 border-b border-gray-700"
             style="background-color: rgba(18, 28, 40, 0.7); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
            
            <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
                
                <a href="#hero" class="flex items-center">
                    <img src="src/gambar/logo.png" alt="NTN INDUSTRIES Logo" class="h-8 lg:h-12">
                </a>
                
                <div class="hidden lg:flex flex-grow items-center justify-end">
                    <ul class="flex space-x-8 text-lg font-medium">
                        <li><a href="#hero" class="text-gray-300 hover:text-secondary transition">Home</a></li>
                        <li><a href="#about" class="text-gray-300 hover:text-secondary transition">Tentang</a></li>
                        <li><a href="#services" class="text-gray-300 hover:text-secondary transition">Layanan</a></li>
                        <li><a href="#portfolio" class="text-gray-300 hover:text-secondary transition">Portofolio</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-secondary transition">Kontak</a></li>
                    </ul>

                    <?php if ($isLoggedIn): ?>
                    <div class="flex space-x-4 ml-8">
                        <span class="text-gray-300 font-medium" style="align-self: center;">Halo, <?= htmlspecialchars($username); ?></span>
                        <a href="auth.php?logout=1" class="text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105"
                           style="background-color: rgba(74, 144, 226, 0.6); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.5);">
                            Logout
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="flex space-x-4 ml-8">
                        <a href="auth.php#login" class="text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105"
                           style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
                            Login
                        </a>
                        <a href="auth.php#register" class="text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105"
                           style="background-color: rgba(74, 144, 226, 0.6); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.5);"
                           onmouseover="this.style.boxShadow='0 0 20px rgba(74, 144, 226, 0.8)'"
                           onmouseout="this.style.boxShadow='0 0 10px rgba(74, 144, 226, 0.4)'">
                            Register
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($isLoggedIn): ?>
                <a href="auth.php?logout=1" class="lg:hidden text-white font-semibold py-2 px-3 text-sm rounded-lg transition transform hover:scale-105"
                   style="background-color: rgba(74, 144, 226, 0.6); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.5);">
                    Logout
                </a>
                <?php else: ?>
                <a href="auth.php#register" class="lg:hidden text-white font-semibold py-2 px-3 text-sm rounded-lg transition transform hover:scale-105"
                   style="background-color: rgba(74, 144, 226, 0.6); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.5);">
                    Register
                </a>
                <?php endif; ?>
            </div>
            
            <div class="lg:hidden bg-gray-900/50 border-t border-gray-700 py-2 overflow-x-auto whitespace-nowrap"
                 style="backdrop-filter: blur(5px);">
                <ul class="flex justify-start px-4 space-x-6 text-sm font-medium">
                    <li><a href="#hero" class="text-gray-300 hover:text-secondary transition">Home</a></li>
                    <li><a href="#about" class="text-gray-300 hover:text-secondary transition">Tentang</a></li>
                    <li><a href="#services" class="text-gray-300 hover:text-secondary transition">Layanan</a></li>
                    <li><a href="#portfolio" class="text-gray-300 hover:text-secondary transition">Portofolio</a></li>
                    <li><a href="#contact" class="text-gray-300 hover:text-secondary transition">Kontak</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        
        <section id="hero" class="bg-gray-900 pt-32 lg:pt-40 pb-24 lg:pb-40 text-center">
            <div class="mx-auto max-w-5xl px-6 lg:px-8">
                <p class="text-lg font-semibold text-secondary mb-3">#RetailFashion #JasaKonveksiTerpercaya #PakaiNTN❤️‍🔥</p>
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold mb-6 text-white leading-tight">
                    Bahan Ganteng, Sabtu Gaul Mu.
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-gray-400 mb-12 max-w-3xl mx-auto">
                    Temukan koleksi pakaian NTN paling trendi atau wujudkan ide pakaian kustom Anda dengan kualitas produksi terbaik.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="products.php" class="text-white font-bold text-lg py-3 px-10 rounded-xl shadow-xl transition transform hover:scale-105"
                       style="background-color: rgba(74, 144, 226, 0.4); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5);">
                        Lihat Koleksi Retail
                    </a>
                    <a href="<?= $isLoggedIn ? '#contact' : 'auth.php?next=contact'; ?>" class="text-white font-bold text-lg py-3 px-10 rounded-xl shadow-xl transition transform hover:scale-105"
                       style="background-color: rgba(74, 144, 226, 0.4); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5);">
                        Jasa Konveksi Custom
                    </a>
                </div>
            </div>
        </section>

        <section id="about" class="py-16 lg:py-24 bg-gray-900">
            <div class="max-w-screen-xl mx-auto px-6 lg:px-8">
                <h2 class="text-3xl lg:text-4xl font-bold text-center mb-10 lg:mb-16 text-white">Cerita Singkat Kami</h2>
                
                <div class="lg:flex lg:space-x-12 items-center">
                    
                    <div class="lg:w-1/2 mb-8 lg:mb-0 relative">
                        <div class="aspect-square w-full rounded-2xl overflow-hidden mx-auto max-w-xs lg:max-w-sm cinematic-box"> 
                            
                            <video class="w-full h-full object-cover" 
                                   src="src/video/timeline.mp4" 
                                   autoplay 
                                   loop 
                                   muted 
                                   playsinline>
                                Video tidak didukung oleh browser Anda.
                            </video>

                        </div>
                    </div>
                    
                    <div class="lg:w-1/2">
                        <h3 class="text-2xl lg:text-3xl font-semibold mb-4 lg:mb-6 text-white">Dua Pilar Kekuatan Kami</h3>
                        <div class="space-y-4 lg:space-y-6">
                            <p class="text-base lg:text-lg text-gray-300">
                                <strong>Retail Pakaian:</strong> Sejak 2020, kami telah menciptakan brand fashion <strong>NTN</strong> yang dikenal karena desain minimalis dan kualitas bahan premium.
                            </p>
                            <p class="text-base lg:text-lg text-gray-300">
                                <strong>Jasa Konveksi:</strong> Kami menawarkan solusi produksi pakaian lengkap, melayani brand, komunitas, dan perusahaan dengan kebutuhan seragam/merchandise.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 lg:py-24 bg-primary">
            <div class="max-w-screen-xl mx-auto px-6 lg:px-8">
                <h2 class="text-4xl font-bold text-center mb-8 text-white">
                    Contoh Jasa Retail & Konveksi Kami
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                    <div class="bg-gray-800 p-6 rounded-xl border-l-8 border-secondary">
                        <h3 class="text-2xl font-bold text-secondary mb-4">Retail: <?= $tshirt->getName(); ?></h3>
                        <p class="text-gray-300">
                            <strong>Status Stok:</strong> <?= $tshirt->getStockStatus(); ?> <br>
                            <strong>Harga:</strong> Rp <?= number_format($tshirt->getPrice(), 0, ',', '.'); ?> <br>
                            <strong>SKU (Public):</strong> <?= $tshirt->sku; ?> 
                        </p>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-xl border-l-8 border-secondary">
                        <h3 class="text-2xl font-bold text-secondary mb-4">Retail: <?= $hoodie->getName(); ?></h3>
                        <p class="text-gray-300">
                            <strong>Status Stok:</strong> <?= $hoodie->getStockStatus(); ?> <br>
                            <strong>Harga:</strong> Rp <?= number_format($hoodie->getPrice(), 0, ',', '.'); ?> <br>
                            <strong>SKU (Public):</strong> <?= $hoodie->sku; ?> 
                        </p>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-xl border-l-8 border-secondary">
                        <h3 class="text-2xl font-bold text-secondary mb-4">Konveksi: <?= $jasaKonveksi->getName(); ?></h3>
                        <p class="text-gray-300">
                            <strong>Min Order (MOQ):</strong> <?= $jasaKonveksi->getMinOrder(); ?> unit <br>
                            <strong>Harga Estimasi:</strong> Rp <?= number_format($jasaKonveksi->getPrice(), 0, ',', '.'); ?> <br>
                            <strong>SKU (Public):</strong> <?= $jasaKonveksi->sku; ?>
                        </p>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-xl border-l-8 border-secondary">
                        <h3 class="text-2xl font-bold text-secondary mb-4">Konveksi: <?= $jasaPolo->getName(); ?></h3>
                        <p class="text-gray-300">
                            <strong>Min Order (MOQ):</strong> <?= $jasaPolo->getMinOrder(); ?> unit <br>
                            <strong>Harga Estimasi:</strong> Rp <?= number_format($jasaPolo->getPrice(), 0, ',', '.'); ?> <br>
                            <strong>SKU (Public):</strong> <?= $jasaPolo->sku; ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="services" class="py-16 lg:py-24 bg-gray-900">
            <div class="max-w-screen-xl mx-auto px-6 lg:px-8">
                <h2 class="text-3xl lg:text-4xl font-bold text-center mb-4 text-white">Pilihan Layanan Terbaik</h2>
                <p class="text-base lg:text-xl text-center text-gray-400 mb-10 lg:mb-16 max-w-3xl mx-auto">Pilih jalur yang paling sesuai dengan kebutuhan fashion dan bisnis Anda.</p>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    
                    <div class="bg-gray-700 p-8 md:p-12 rounded-2xl shadow-xl border-l-8 border-secondary">
                        <h3 class="text-2xl lg:text-3xl font-bold mb-4 text-white">NTN Retail: Gaya Trendi</h3>
                        <p class="text-base lg:text-lg text-gray-300 mb-6">Koleksi eksklusif pakaian racing siap pakai yang selalu terbaru.</p>
                        <ul class="space-y-3 mb-8 text-gray-300">
                            <li class="flex items-center"><span class="text-secondary mr-3 font-extrabold">&#10003;</span> Desain Minimalis & Eksklusif.</li>
                            <li class="flex items-center"><span class="text-secondary mr-3 font-extrabold">&#10003;</span> Ready Stock.</li>
                        </ul>
                        <a href="products.php" class="text-white font-bold py-3 px-8 rounded-lg transition transform hover:scale-105"
                           style="background-color: rgba(74, 144, 226, 0.4); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5);">
                            Lihat Produk
                        </a>
                    </div>

                    <div class="bg-gray-700 p-8 md:p-12 rounded-2xl shadow-xl border-l-8 border-secondary">
                        <h3 class="text-2xl lg:text-3xl font-bold mb-4 text-white">Jasa Konveksi: Produksi Custom</h3>
                        <p class="text-base lg:text-lg text-gray-300 mb-6">Solusi manufaktur untuk seragam balap, merchandise, atau clothing line Anda.</p>
                        <ul class="space-y-3 mb-8 text-gray-300">
                            <li class="flex items-center"><span class="text-secondary mr-3 font-extrabold">&#10003;</span> MOQ Fleksibel.</li>
                            <li class="flex items-center"><span class="text-secondary mr-3 font-extrabold">&#10003;</span> Sablon/Bordir Presisi.</li>
                        </ul>
                        <a href="<?= $isLoggedIn ? '#contact' : 'auth.php?next=contact'; ?>" class="text-white font-bold py-3 px-8 rounded-lg transition transform hover:scale-105"
                           style="background-color: rgba(74, 144, 226, 0.4); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5);">
                            Mulai Konsultasi
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="portfolio" class="py-16 lg:py-24 bg-primary">
            <div class="max-w-screen-xl mx-auto px-6 lg:px-8">
                <h2 class="text-3xl lg:text-4xl font-bold text-center mb-4 text-white">Portofolio Produksi</h2>
                <p class="text-base lg:text-xl text-center text-gray-400 mb-10 lg:mb-16 max-w-3xl mx-auto">Bukti nyata kualitas jahitan dan cetakan kami.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    
                    <div class="rounded-xl overflow-hidden shadow-lg transform hover:scale-[1.03] transition duration-300 bg-gray-800">
                        <div class="aspect-w-4 aspect-h-3">
                            <img src="src/gambar/ntnhoodie.jpg" alt="Proyek Jaket Komunitas" 
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <div class="p-6 border-t-4 border-secondary">
                            <h4 class="text-xl font-semibold text-white">Hoodie NTN Gang</h4>
                            <p class="text-sm text-gray-400 mt-1">Produk: Retail NTN Fashion</p>
                        </div>
                    </div>
                    
                    <div class="rounded-xl overflow-hidden shadow-lg transform hover:scale-[1.03] transition duration-300 bg-gray-800">
                         <div class="aspect-w-4 aspect-h-3">
                            <img src="src/gambar/ntntshirt.jpg" alt="Koleksi Kaos NTN Terbaru" 
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <div class="p-6 border-t-4 border-secondary">
                            <h4 class="text-xl font-semibold text-white">T-Shirt "NTN FIRE" Longsleeve Series</h4>
                            <p class="text-sm text-gray-400 mt-1">Produk: Retail NTN Fashion</p>
                        </div>
                    </div>
                    
                    <div class="rounded-xl overflow-hidden shadow-lg transform hover:scale-[1.03] transition duration-300 bg-gray-800">
                        <div class="aspect-w-4 aspect-h-3">
                            <img src="src/gambar/ntnpolo.jpg" alt="Seragam Polo Perusahaan" 
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <div class="p-6 border-t-4 border-secondary">
                            <h4 class="text-xl font-semibold text-white">Jersey Polo "WE GANG GANG"</h4>
                            <p class="text-sm text-gray-400 mt-1">Produk: Retail NTN Fashion</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonial" class="py-16 lg:py-24 bg-gray-800">
            <div class="max-w-screen-xl mx-auto px-6 lg:px-8">
                <h2 class="text-3xl lg:text-4xl font-bold text-center mb-4 text-white">Apa Kata Klien Kami?</h2>
                <p class="text-base lg:text-xl text-center text-gray-400 mb-10 lg:mb-16 max-w-3xl mx-auto">Kami bangga dengan kepuasan dari pelanggan retail dan klien konveksi kami.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
                    <div class="bg-gray-900 p-8 rounded-xl shadow-lg"
                         style="border-left: 8px solid rgba(74, 144, 226, 0.5);">
                        <p class="italic text-lg text-gray-300 mb-6">
                            "Kualitas jahitan seragamnya sangat rapi dan pengiriman tepat waktu. NTN adalah mitra konveksi andalan untuk perusahaan kami!"
                        </p>
                        <p class="font-semibold text-secondary">- Budi Santoso, Project Manager PT. Inovasi Digital</p>
                    </div>
                    <div class="bg-gray-900 p-8 rounded-xl shadow-lg"
                         style="border-left: 8px solid rgba(74, 144, 226, 0.5);">
                        <p class="italic text-lg text-gray-300 mb-6">
                            "T-Shirt NTN nyaman banget dipakai, bahannya adem, dan cutting-nya modern. Selalu menunggu koleksi baru!"
                        </p>
                        <p class="font-semibold text-secondary">- Rina Wijaya, Pelanggan Retail</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-16 lg:py-24 bg-primary text-white">
            <div class="max-w-screen-xl mx-auto px-6 lg:px-8 text-center">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">Mulai Proyek Custom Anda</h2>
                <p class="text-base lg:text-xl font-light mb-10 max-w-3xl mx-auto">Dapatkan konsultasi gratis dan penawaran harga terbaik untuk jasa konveksi atau tanyakan ketersediaan produk retail kami.</p>
                
                <?php if (!$isLoggedIn): ?>
                <p class="text-sm text-gray-300 mb-4">Silakan login atau register terlebih dahulu untuk mengirim pesan konsultasi.</p>
                <?php endif; ?>
                <form class="max-w-xl mx-auto space-y-4"<?php if (!$isLoggedIn): ?> action="auth.php" method="get"<?php endif; ?>>
                    <?php if (!$isLoggedIn): ?>
                    <input type="hidden" name="next" value="contact">
                    <?php endif; ?>
                    <input type="text" placeholder="Nama Lengkap" class="w-full p-3 rounded-lg text-white-900 focus:outline-none focus:ring-2 focus:ring-secondary">
                    <input type="email" placeholder="Email atau Nomor WA" class="w-full p-3 rounded-lg text-white-900 focus:outline-none focus:ring-2 focus:ring-secondary">
                    <textarea placeholder="Pesan Anda (misal: Pesan 50 Kaos Sablon)" rows="4" class="w-full p-3 rounded-lg text-white-900 focus:outline-none focus:ring-2 focus:ring-secondary"></textarea>
                    
                    <button type="submit" class="w-full text-white font-bold text-lg py-3 rounded-xl shadow-lg transition transform hover:scale-105"
                            style="background-color: rgba(74, 144, 226, 0.5); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.5);">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </section>
    </main>

    <footer class="text-white py-10"
            style="background-color: rgba(18, 28, 40, 0.7); backdrop-filter: blur(10px); border-top: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-8 text-center">
            <nav aria-label="Footer" class="flex flex-wrap justify-center gap-x-6 gap-y-3 text-sm font-medium mb-6">
                <a href="#about" class="text-gray-400 hover:text-secondary transition">Tentang</a>
                <a href="#services" class="text-gray-400 hover:text-secondary transition">Layanan</a>
                <a href="#portfolio" class="text-gray-400 hover:text-secondary transition">Portofolio</a>
                <a href="#contact" class="text-gray-400 hover:text-secondary transition">Kontak</a>
            </nav>
            <p class="text-sm text-gray-500">&copy; 2025 NTN INDUSTRIES. All rights reserved.</p>
        </div>
    </footer>
    
</body>
</html>