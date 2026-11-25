<?php

namespace App\Models;

class Retail extends Product
{
    private $stockStatus;

    public function __construct($name = null, $price = null, $sku = null, $stockStatus = null)
    {
        parent::__construct($name, $price, $sku);
        $this->stockStatus = $stockStatus;
    }

    public function getStockStatus()
    {
        return $this->stockStatus;
    }

    public function displayProductDetail()
    {
        return "RETAIL | {$this->name} - Stok: {$this->stockStatus}";
    }
}
