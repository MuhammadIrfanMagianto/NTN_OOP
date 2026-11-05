<?php
// Controller/AuthController.php
// Menangani request Login, Register & Logout (auth.php)
namespace NTNIndustries\Controller;

use NTNIndustries\Model\User;

class AuthController extends BaseController {

    const MIN_PASSWORD = 6;

    // Halaman tujuan setelah login (dipilih lewat auth.php?next=...)
    private $nextPages = [
        'products' => [
            'url'     => 'products.php',
            'message' => 'Silakan login atau register terlebih dahulu untuk melihat produk.'
        ],
        'contact' => [
            'url'     => 'index.php#contact',
            'message' => 'Silakan login atau register terlebih dahulu untuk melakukan konsultasi.'
        ],
    ];

    // REQUEST -> CONTROLLER -> MODEL -> VIEW
    public function index() {
        $this->startSession();

        // Logout: auth.php?logout=1
        if (isset($_GET['logout'])) {
            $this->logout();
        }

        // Simpan tujuan setelah login jika datang dari ?next=...
        $nextKey = (isset($_GET['next']) && isset($this->nextPages[$_GET['next']])) ? $_GET['next'] : null;

        // Jika user sudah login, langsung ke tujuan (atau index.php)
        if ($this->isLoggedIn()) {
            header("Location: " . ($nextKey ? $this->nextPages[$nextKey]['url'] : 'index.php'));
            exit();
        }

        $message = '';
        $messageType = 'error';
        $activeForm = 'login';
        $hasFlash = isset($_SESSION['flash']);

        // Pesan sekali tampil (misal setelah registrasi berhasil)
        if ($hasFlash) {
            $message = $_SESSION['flash'];
            $messageType = 'success';
            unset($_SESSION['flash']);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($nextKey) {
                $_SESSION['next'] = $nextKey;
                $message = $this->nextPages[$nextKey]['message'];
                $messageType = 'info';
            } elseif (!$hasFlash) {
                unset($_SESSION['next']);   // buka login biasa -> tidak ada tujuan khusus
            }
        }

        try {
            $userModel = new User($this->connect());   // Model

            // Proses form register / login jika di-submit
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $result = $this->process($userModel);
                $message = $result['message'];
                $activeForm = $result['form'];
                $messageType = 'error';
            }

            $userModel->close();
        } catch (\mysqli_sql_exception $e) {
            $message = "Tidak dapat terhubung ke database. Pastikan MySQL sudah berjalan, lalu coba lagi.";
            $messageType = 'error';
        }

        $this->show($message, $activeForm, $messageType);
    }

    // Tampilkan halaman login/register (View)
    public function show($message = '', $activeForm = 'login', $messageType = 'error') {
        $this->render('auth', [
            'message'     => $message,
            'activeForm'  => $activeForm,
            'messageType' => $messageType
        ]);
    }

    // Proses form yang di-submit, return ['message' => ..., 'form' => 'login'|'register']
    public function process(User $userModel) {
        if (isset($_POST['register_submit'])) {
            return $this->register($userModel);
        }

        if (isset($_POST['login_submit'])) {
            return $this->login($userModel);
        }

        return ['message' => '', 'form' => 'login'];
    }

    // --- LOGIKA REGISTER ---
    private function register(User $userModel) {
        $username = trim(isset($_POST['username']) ? $_POST['username'] : '');
        $email = strtolower(trim(isset($_POST['reg-email']) ? $_POST['reg-email'] : ''));
        $password = isset($_POST['reg-password']) ? $_POST['reg-password'] : '';

        $fail = function ($message) {
            return ['message' => $message, 'form' => 'register'];
        };

        // 1. Validasi Input
        if ($username === '' || $email === '' || $password === '') {
            return $fail("Semua field harus diisi!");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
            return $fail("Format email tidak valid.");
        }
        if (strlen($username) < 3 || strlen($username) > 50) {
            return $fail("Username harus 3 - 50 karakter.");
        }
        if (strlen($password) < self::MIN_PASSWORD) {
            return $fail("Password minimal " . self::MIN_PASSWORD . " karakter.");
        }

        // 2. Cek username / email sudah terdaftar
        if ($userModel->usernameExists($username)) {
            return $fail("Username sudah digunakan.");
        }
        if ($userModel->emailExists($email)) {
            return $fail("Email sudah terdaftar.");
        }

        // 3. Simpan ke database (Model meng-hash password)
        if ($userModel->register($username, $email, $password)) {
            // Berhasil, redirect ke halaman login dan tampilkan pesan
            $_SESSION['flash'] = "Registrasi berhasil! Silakan Login.";
            header("Location: auth.php");
            exit();
        }

        return $fail("Registrasi gagal. Username atau email mungkin sudah terdaftar.");
    }

    // --- LOGIKA LOGIN ---
    private function login(User $userModel) {
        $email = strtolower(trim(isset($_POST['email']) ? $_POST['email'] : ''));
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if ($email === '' || $password === '') {
            return ['message' => "Email dan password harus diisi!", 'form' => 'login'];
        }

        $user = $userModel->findByEmail($email);

        if (!$user) {
            return ['message' => "Email tidak ditemukan.", 'form' => 'login'];
        }

        if (!$userModel->verifyPassword($password, $user['password'])) {
            return ['message' => "Password salah.", 'form' => 'login'];
        }

        // Login berhasil: ganti session ID, simpan data user
        $next = isset($_SESSION['next']) ? $_SESSION['next'] : null;
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = true;
        unset($_SESSION['next']);

        // Kembali ke halaman yang tadi dituju (produk / konsultasi), atau index.php
        header("Location: " . (($next && isset($this->nextPages[$next])) ? $this->nextPages[$next]['url'] : 'index.php'));
        exit();
    }

    private function logout() {
        $_SESSION = [];
        session_destroy();
        header("Location: index.php");
        exit();
    }

    // Koneksi database (src/db_connect.php)
    private function connect() {
        require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'db_connect.php';
        return $conn;
    }
}
