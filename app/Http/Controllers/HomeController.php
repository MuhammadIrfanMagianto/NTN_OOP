<?php
// app/Http/Controllers/HomeController.php
// Menangani request halaman utama (route: /)
namespace App\Http\Controllers;

use App\Models\ProductCatalog;

class HomeController extends Controller
{
    // REQUEST -> CONTROLLER -> MODEL -> VIEW
    public function index()
    {
        $catalog = new ProductCatalog();          // Model
        $data = $catalog->getFeaturedItems();     // Data dari Model

        return $this->render('home', $data);      // Kirim ke View
    }
}
