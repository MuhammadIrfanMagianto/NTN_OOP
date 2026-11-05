<?php
// Controller/BaseController.php
// Controller dasar: session/login helper + render() untuk meneruskan data ke View.
namespace NTNIndustries\Controller;

class BaseController {

    protected function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function isLoggedIn() {
        $this->startSession();
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    // Halaman yang wajib login: jika belum login, arahkan ke auth.php
    // (setelah login user dikembalikan ke halaman tujuan). $next: 'products' / 'contact'
    protected function requireLogin($next) {
        if (!$this->isLoggedIn()) {
            header("Location: auth.php?next=" . urlencode($next));
            exit();
        }
    }

    // Controller -> View: kirim $data ke file di folder View/
    protected function render($view, $data = []) {
        $viewFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \Exception("View tidak ditemukan: " . $viewFile);
        }

        // Status login tersedia di semua View (untuk tombol Login / Logout)
        $data['isLoggedIn'] = $this->isLoggedIn();
        $data['username'] = isset($_SESSION['username']) ? $_SESSION['username'] : '';

        // $data otomatis tersedia di dalam file View
        require $viewFile;
    }
}
