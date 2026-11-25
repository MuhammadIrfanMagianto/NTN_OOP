<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    const MIN_PASSWORD = 6;

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

    public function index(Request $request)
    {
        $nextPages = $this->nextPages();
        $session   = $request->session();

        $next    = $request->query('next');
        $nextKey = (is_string($next) && isset($nextPages[$next])) ? $next : null;

        if (Auth::check()) {
            return redirect($nextKey ? $nextPages[$nextKey]['url'] : route('home'));
        }

        $message     = '';
        $messageType = 'error';
        $activeForm  = 'login';
        $hasFlash    = $session->has('flash');

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
                $session->forget('next');
            }
        }

        try {
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

    public function show($message = '', $activeForm = 'login', $messageType = 'error')
    {
        return $this->render('auth', [
            'message'     => $message,
            'activeForm'  => $activeForm,
            'messageType' => $messageType,
        ]);
    }

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

    private function register(Request $request)
    {
        $fail = function ($message) {
            return ['message' => $message, 'form' => 'register'];
        };

        try {
            $request->validate([
                'username'     => 'required|string|min:3|max:50',
                'reg-email'    => 'required|email|max:100',
                'reg-password' => 'required|string|min:' . self::MIN_PASSWORD,
            ], [
                'username.required'     => 'Semua field harus diisi!',
                'username.min'          => 'Username harus 3 - 50 karakter.',
                'username.max'          => 'Username harus 3 - 50 karakter.',
                'reg-email.required'    => 'Semua field harus diisi!',
                'reg-email.email'       => 'Format email tidak valid.',
                'reg-email.max'         => 'Email maksimal 100 karakter.',
                'reg-password.required' => 'Semua field harus diisi!',
                'reg-password.min'      => 'Password minimal ' . self::MIN_PASSWORD . ' karakter.',
            ]);
        } catch (ValidationException $e) {
            return $fail($e->validator->errors()->first());
        }

        $username = trim((string) $request->input('username'));
        $email    = strtolower(trim((string) $request->input('reg-email')));
        $password = (string) $request->input('reg-password');

        if (User::usernameExists($username)) {
            return $fail("Username sudah digunakan.");
        }
        if (User::emailExists($email)) {
            return $fail("Email sudah terdaftar.");
        }

        if (User::register($username, $email, $password)) {
            $request->session()->put('flash', "Registrasi berhasil! Silakan Login.");
            return redirect()->route('auth');
        }

        return $fail("Registrasi gagal. Username atau email mungkin sudah terdaftar.");
    }

    private function login(Request $request)
    {
        $nextPages = $this->nextPages();

        try {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string',
            ], [
                'email.required'    => 'Email dan password harus diisi!',
                'email.email'       => 'Format email tidak valid.',
                'password.required' => 'Email dan password harus diisi!',
            ]);
        } catch (ValidationException $e) {
            return ['message' => $e->validator->errors()->first(), 'form' => 'login'];
        }

        $email    = strtolower(trim((string) $request->input('email')));
        $password = (string) $request->input('password');

        $user = User::findByEmail($email);

        if (!$user) {
            return ['message' => "Email tidak ditemukan.", 'form' => 'login'];
        }

        if (!Hash::check($password, $user->password)) {
            return ['message' => "Password salah.", 'form' => 'login'];
        }

        $next = $request->session()->get('next');
        Auth::login($user);
        $request->session()->forget('next');

        return redirect(($next && isset($nextPages[$next])) ? $nextPages[$next]['url'] : route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
