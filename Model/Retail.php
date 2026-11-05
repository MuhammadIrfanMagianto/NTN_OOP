<?php
// Model/Retail.php
namespace NTNIndustries\Model;

class Retail extends Product {
    private $stockStatus;

    public function __construct($name, $price, $sku, $stockStatus) {
        parent::__construct($name, $price, $sku);
        $this->stockStatus = $stockStatus;
    }

    // Method 3
    public function getStockStatus() {
        return $this->stockStatus;
    }
    
    // Method 4
    public function displayProductDetail() {
        return "RETAIL | {$this->name} - Stok: {$this->stockStatus}";
    }
}
