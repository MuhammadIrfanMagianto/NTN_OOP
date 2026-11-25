<?php
// app/Http/Controllers/ProductController.php
// Menangani halaman produk (/products) dan endpoint JSON (/api/products)
// Halaman & API produk hanya bisa diakses setelah login.
namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Halaman Koleksi Produk (data diambil via fetch ke /api/products)
    public function index()
    {
        // belum login -> halaman login (setelah login kembali ke produk)
        if (!Auth::check()) {
            return redirect()->route('auth', ['next' => 'products']);
        }

        return $this->render('products');
    }

    // Endpoint JSON (API produk NTN)
    //   /api/products               -> semua produk
    //   /api/products?type=retail   -> hanya retail   (atau type=konveksi)
    //   /api/products?id=2          -> satu produk
    public function api(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(["error" => "Silakan login terlebih dahulu"], 401);
        }

        $catalog = new ProductCatalog();          // Model

        if ($request->has('id')) {
            $product = $catalog->findApiProduct($request->query('id'));
            if ($product === null) {
                return response()->json(["error" => "Produk tidak ditemukan"], 404);
            }
            return response()->json($product);
        }

        $type = $request->query('type');
        return response()->json($catalog->getApiProducts(is_string($type) ? $type : null));
    }
}
