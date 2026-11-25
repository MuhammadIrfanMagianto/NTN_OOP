<?php
// app/Http/Controllers/Controller.php
// Controller dasar (pengganti BaseController lama): helper render() untuk meneruskan data ke View.
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    // Controller -> View: kirim $data ke resources/views/{$view}.blade.php
    protected function render(string $view, array $data = [])
    {
        // Status login tersedia di semua View (untuk tombol Login / Logout)
        $data['isLoggedIn'] = Auth::check();
        $data['username']   = Auth::check() ? Auth::user()->username : '';

        return view($view, $data);
    }
}
