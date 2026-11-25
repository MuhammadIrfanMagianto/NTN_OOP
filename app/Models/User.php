<?php
// app/Models/User.php
// Model yang mengelola data USER di database (register & login).
// Sekarang memakai Eloquent; tabel `users` sama persis dengan database.sql lama,
// jadi akun yang sudah terdaftar tetap bisa login (hash bcrypt kompatibel).
namespace App\Models;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';

    // Tabel lama hanya punya created_at (diisi otomatis oleh database)
    public $timestamps = false;

    protected $fillable = ['username', 'email', 'password'];

    protected $hidden = ['password'];

    // Tabel lama tidak punya kolom remember_token
    public function getRememberTokenName()
    {
        return '';
    }

    // Method wajib JWTSubject (Week 11)
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function usernameExists($username)
    {
        return static::where('username', $username)->exists();
    }

    public static function emailExists($email)
    {
        return static::where('email', $email)->exists();
    }

    // Simpan user baru. Password di-hash di sini. Return true jika berhasil,
    // false jika username/email sudah dipakai (duplicate key).
    public static function register($username, $email, $password)
    {
        try {
            static::create([
                'username' => $username,
                'email'    => $email,
                'password' => Hash::make($password),
            ]);
            return true;
        } catch (QueryException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {   // Duplicate entry
                return false;
            }
            throw $e;
        }
    }

    // Cari user berdasarkan email. Return User atau null.
    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }
}
