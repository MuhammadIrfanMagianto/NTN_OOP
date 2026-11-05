<?php
// View/auth.php
// View hanya menampilkan data yang dikirim Controller ($data).
$message = $data['message'];
$activeForm = $data['activeForm'];
$messageType = isset($data['messageType']) ? $data['messageType'] : 'error';
$messageColors = ['success' => '#16a34a', 'info' => '#4A90E2', 'error' => '#dc2626'];
?>
<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | NTN INDUSTRIES</title>
    <link rel="icon" type="image/png" href="src/gambar/favicon.png">
    <link href="./output.css" rel="stylesheet"> 
</head>
<body class="font-primary antialiased bg-gray-900 text-gray-100">

    <main class="min-h-screen flex items-center justify-center p-4">
        
        <div class="w-full max-w-md">
            
            <div class="text-center mb-10">
                <a href="index.php" class="flex justify-center items-center">
                    <img src="src/gambar/logo.png" alt="NTN INDUSTRIES Logo" class="h-10">
                </a>
            </div>

            <div id="notification-message" class="hidden p-4 mb-4 text-sm font-semibold text-center rounded-lg shadow-lg text-white"
                 style="background-color: <?php echo $messageColors[$messageType]; ?>;">
                <?php echo htmlspecialchars($message); ?>
            </div>

            <div id="auth-card" class="rounded-xl p-8 shadow-2xl"
                 style="background-color: rgba(18, 28, 40, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1);">
                
                <div class="flex mb-6 border-b border-gray-700">
                    <button id="login-tab" class="w-1/2 py-2 text-lg font-bold border-b-2 border-secondary transition">
                        LOGIN
                    </button>
                    <button id="register-tab" class="w-1/2 py-2 text-lg font-medium text-gray-500 hover:text-white transition">
                        REGISTER
                    </button>
                </div>

                <form id="login-form" method="POST" action="auth.php" class="space-y-6">
                    <h2 class="text-2xl font-bold text-white mb-4">Masuk ke Akun Anda</h2>
                    <input type="hidden" name="login_submit" value="1">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                        <input type="email" name="email" id="email" required placeholder="Masukkan email Anda"
                               class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-secondary focus:border-secondary transition">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-400 mb-1">Password</label>
                        <input type="password" name="password" id="password" required placeholder="Masukkan password"
                               class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-secondary focus:border-secondary transition">
                    </div>
                    
                    <button type="submit"
                       class="w-full block text-center text-white font-bold text-lg py-3 rounded-lg transition transform hover:scale-[1.01]"
                       style="background-color: #4A90E2; box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);">
                        LOGIN
                    </button>

                    <p class="text-center text-sm text-gray-400 mt-4">
                        Belum punya akun? <a href="#" id="switch-to-register" class="text-secondary hover:underline">Daftar Sekarang</a>
                    </p>
                </form>

                <form id="register-form" method="POST" action="auth.php" class="space-y-6 hidden">
                    <h2 class="text-2xl font-bold text-white mb-4">Buat Akun Baru</h2>
                    <input type="hidden" name="register_submit" value="1">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-400 mb-1">Username</label>
                        <input type="text" name="username" id="username" required placeholder="Pilih username unik"
                               class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-secondary focus:border-secondary transition">
                    </div>
                    <div>
                        <label for="reg-email" class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                        <input type="email" name="reg-email" id="reg-email" required placeholder="Masukkan email Anda"
                               class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-secondary focus:border-secondary transition">
                    </div>
                    <div>
                        <label for="reg-password" class="block text-sm font-medium text-gray-400 mb-1">Password</label>
                        <input type="password" name="reg-password" id="reg-password" required placeholder="Buat password (min 6 karakter)"
                               class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-secondary focus:border-secondary transition">
                    </div>
                    
                    <button type="submit"
                            class="w-full block text-center text-white font-bold text-lg py-3 rounded-lg transition transform hover:scale-[1.01]"
                            style="background-color: #4A90E2; box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);">
                        REGISTER
                    </button>

                    <p class="text-center text-sm text-gray-400 mt-4">
                        Sudah punya akun? <a href="#" id="switch-to-login" class="text-secondary hover:underline">Masuk</a>
                    </p>
                </form>

            </div>
        </div>

    </main>
    
    <script>
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const loginTab = document.getElementById('login-tab');
        const registerTab = document.getElementById('register-tab');
        const switchToRegisterLink = document.getElementById('switch-to-register');
        const switchToLoginLink = document.getElementById('switch-to-login');
        const notification = document.getElementById('notification-message');

        function showForm(formToShow) {
            // Hilangkan class aktif pada tab lama
            loginTab.classList.remove('border-secondary', 'text-secondary', 'border-gray-700');
            registerTab.classList.remove('border-secondary', 'text-secondary', 'border-gray-700');
            loginTab.classList.add('border-gray-700', 'text-gray-500');
            registerTab.classList.add('border-gray-700', 'text-gray-500');
            
            if (formToShow === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                loginTab.classList.add('border-secondary', 'text-secondary');
                loginTab.classList.remove('border-gray-700', 'text-gray-500');
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                registerTab.classList.add('border-secondary', 'text-secondary');
                registerTab.classList.remove('border-gray-700', 'text-gray-500');
            }
        }

        loginTab.addEventListener('click', () => showForm('login'));
        registerTab.addEventListener('click', () => showForm('register'));
        switchToRegisterLink.addEventListener('click', (e) => { e.preventDefault(); showForm('register'); });
        switchToLoginLink.addEventListener('click', (e) => { e.preventDefault(); showForm('login'); });
        
        // 1. Tentukan form yang harus tampil berdasarkan pesan notifikasi atau hash URL
        const urlParams = new URLSearchParams(window.location.search);
        const urlHash = window.location.hash;
        
        let initialForm = '<?= $activeForm === 'register' ? 'register' : 'login'; ?>';
        if (urlHash === '#register') {
            initialForm = 'register';
        }

        showForm(initialForm);

        // 2. Tampilkan pesan jika ada
        if (notification.innerHTML.trim() !== '') {
            notification.classList.remove('hidden');
        }
    </script>
</body>
</html>