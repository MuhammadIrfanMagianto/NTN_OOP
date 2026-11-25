<?php
// app/Http/Controllers/AuthController.php
// Menangani request Login, Register & Logout (route: /auth dan /logout)
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    const MIN_PASSWORD = 6;

    // Halaman tujuan setelah login (dipilih lewat /auth?next=...)
    private function nextPages(): array
    {
        return [
            'products' => [
                'url'     => route('products'),
                'message' => 'Silakan login atau register terlebih dahulu untuk melihat produk.',
            ],
            'contact' => [
                'url'     => route('home') . '#contact',
                'message' => 'Silakan login atau register terlebih dahulu untuk melakukan konsultasi.',
            ],
        ];
    }

    // REQUEST -> CONTROLLER -> MODEL -> VIEW
    public function index(Request $request)
    {
        $nextPages = $this->nextPages();
        $session   = $request->session();

        // Simpan tujuan setelah login jika datang dari ?next=...
        $next    = $request->query('next');
        $nextKey = (is_string($next) && isset($nextPages[$next])) ? $next : null;

        // Jika user sudah login, langsung ke tujuan (atau halaman utama)
        if (Auth::check()) {
            return redirect($nextKey ? $nextPages[$nextKey]['url'] : route('home'));
        }

        $message     = '';
        $messageType = 'error';
        $activeForm  = 'login';
        $hasFlash    = $session->has('flash');

        // Pesan sekali tampil (misal setelah registrasi berhasil)
        if ($hasFlash) {
            $message     = $session->pull('flash');
            $messageType = 'success';
        }

        if ($request->isMethod('get')) {
            if ($nextKey) {
                $session->put('next', $nextKey);
                $message     = $nextPages[$nextKey]['message'];
                $messageType = 'info';
            } elseif (!$hasFlash) {
                $session->forget('next');   // buka login biasa -> tidak ada tujuan khusus
            }
        }

        try {
            // Proses form register / login jika di-submit
            if ($request->isMethod('post')) {
                $result = $this->process($request);

                if ($result instanceof RedirectResponse) {
                    return $result;
                }

                $message     = $result['message'];
                $activeForm  = $result['form'];
                $messageType = 'error';
            }
        } catch (QueryException $e) {
            $message     = "Tidak dapat terhubung ke database. Pastikan MySQL sudah berjalan, lalu coba lagi.";
            $messageType = 'error';
        }

        return $this->show($message, $activeForm, $messageType);
    }

    // Tampilkan halaman login/register (View)
    public function show($message = '', $activeForm = 'login', $messageType = 'error')
    {
        return $this->render('auth', [
            'message'     => $message,
            'activeForm'  => $activeForm,
            'messageType' => $messageType,
        ]);
    }

    // Proses form yang di-submit. Return array ['message' => ..., 'form' => 'login'|'register']
    // atau RedirectResponse jika berhasil.
    public function process(Request $request)
    {
        if ($request->has('register_submit')) {
            return $this->register($request);
        }

        if ($request->has('login_submit')) {
            return $this->login($request);
        }

        return ['message' => '', 'form' => 'login'];
    }

    // --- LOGIKA REGISTER ---
    private function register(Request $request)
    {
        $username = trim((string) $request->input('username', ''));
        $email    = strtolower(trim((string) $request->input('reg-email', '')));
        $password = (string) $request->input('reg-password', '');

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
        if (User::usernameExists($username)) {
            return $fail("Username sudah digunakan.");
        }
        if (User::emailExists($email)) {
            return $fail("Email sudah terdaftar.");
        }

        // 3. Simpan ke database (Model meng-hash password)
        if (User::register($username, $email, $password)) {
            // Berhasil, redirect ke halaman login dan tampilkan pesan
            $request->session()->put('flash', "Registrasi berhasil! Silakan Login.");
            return redirect()->route('auth');
        }

        return $fail("Registrasi gagal. Username atau email mungkin sudah terdaftar.");
    }

    // --- LOGIKA LOGIN ---
    private function login(Request $request)
    {
        $nextPages = $this->nextPages();

        $email    = strtolower(trim((string) $request->input('email', '')));
        $password = (string) $request->input('password', '');

        if ($email === '' || $password === '') {
            return ['message' => "Email dan password harus diisi!", 'form' => 'login'];
        }

        $user = User::findByEmail($email);

        if (!$user) {
            return ['message' => "Email tidak ditemukan.", 'form' => 'login'];
        }

        if (!Hash::check($password, $user->password)) {
            return ['message' => "Password salah.", 'form' => 'login'];
        }

        // Login berhasil: simpan user ke session (session ID otomatis diganti)
        $next = $request->session()->get('next');
        Auth::login($user);
        $request->session()->forget('next');

        // Kembali ke halaman yang tadi dituju (produk / konsultasi), atau halaman utama
        return redirect(($next && isset($nextPages[$next])) ? $nextPages[$next]['url'] : route('home'));
    }

    // Logout (route: /logout)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
