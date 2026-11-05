<?php
// Model/Product.php
namespace NTNIndustries\Model;

class Product {
    // Access Modifier: protected dan private
    protected $name; 
    private $price;  
    public $sku;     
    
    // Magic Method: __construct
    public function __construct($name, $price, $sku) {
        $this->name = $name;
        $this->price = $price;
        $this->sku = $sku;
    }

    // Method 1 & 2
    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    // Magic Method: __toString
    public function __toString() {
        return "Produk: {$this->name} (SKU: {$this->sku})";
    }
}
