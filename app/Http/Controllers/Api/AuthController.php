<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

class AuthController extends Controller
{
    // POST /api/login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan.',
            ], 401);
        }

        /** @var JWTGuard $guard */
        $guard = auth('api');

        if (!$token = $guard->attempt($credentials)) {
            return response()->json([
                'message' => 'Password salah.',
            ], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $guard->factory()->getTTL() * 60,
            'user'         => [
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
            ],
        ], 200);
    }

    // GET /api/me
    public function me()
    {
        /** @var JWTGuard $guard */
        $guard = auth('api');

        return response()->json([
            'user' => $guard->user(),
        ], 200);
    }

    // POST /api/logout
    public function logout()
    {
        /** @var JWTGuard $guard */
        $guard = auth('api');
        $guard->logout();

        return response()->json([
            'message' => 'Logout berhasil.',
        ], 200);
    }
}
