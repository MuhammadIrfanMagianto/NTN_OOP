<?php
// Controller/ProductController.php
// Menangani request halaman produk (products.php) dan endpoint JSON (api_products.php)
// Halaman & API produk hanya bisa diakses setelah login.
namespace NTNIndustries\Controller;

use NTNIndustries\Model\ProductCatalog;

class ProductController extends BaseController {

    // Halaman Koleksi Produk (data diambil via fetch ke api_products.php)
    public function index() {
        $this->requireLogin('products');   // belum login -> auth.php

        $this->render('products');
    }

    // Endpoint JSON (API produk NTN)
    //   api_products.php               -> semua produk
    //   api_products.php?type=retail   -> hanya retail   (atau type=konveksi)
    //   api_products.php?id=2          -> satu produk
    public function api() {
        // Wajib: Atur header agar browser tahu bahwa ini adalah JSON, bukan HTML
        header('Content-Type: application/json');

        if (!$this->isLoggedIn()) {
            http_response_code(401);
            echo json_encode(["error" => "Silakan login terlebih dahulu"]);
            return;
        }

        $catalog = new ProductCatalog();          // Model

        if (isset($_GET['id'])) {
            $product = $catalog->findApiProduct($_GET['id']);
            if ($product === null) {
                http_response_code(404);
                echo json_encode(["error" => "Produk tidak ditemukan"]);
                return;
            }
            echo json_encode($product);
            return;
        }

        $type = isset($_GET['type']) ? $_GET['type'] : null;
        echo json_encode($catalog->getApiProducts($type));
    }
}
