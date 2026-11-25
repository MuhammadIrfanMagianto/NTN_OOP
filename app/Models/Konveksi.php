<?php
// app/Models/Konveksi.php
namespace App\Models;

class Konveksi extends Product {
    private $minOrder;

    public function __construct($name = null, $price = null, $sku = null, $minOrder = null) {
        parent::__construct($name, $price, $sku);
        $this->minOrder = $minOrder;
    }

    // Method 5
    public function getMinOrder() {
        return $this->minOrder;
    }

    public function __destruct() {
        // Logika cleanup
    }
}
