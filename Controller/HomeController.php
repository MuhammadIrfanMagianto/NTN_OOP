<?php
// Controller/HomeController.php
// Menangani request halaman utama (index.php)
namespace NTNIndustries\Controller;

use NTNIndustries\Model\ProductCatalog;

class HomeController extends BaseController {

    // REQUEST -> CONTROLLER -> MODEL -> VIEW
    public function index() {
        $catalog = new ProductCatalog();          // Model
        $data = $catalog->getFeaturedItems();     // Data dari Model

        $this->render('home', $data);             // Kirim ke View
    }
}
