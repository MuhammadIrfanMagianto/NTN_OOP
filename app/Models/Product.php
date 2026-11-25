<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nama',
        'kategori',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
    ];

    protected $casts = [
        'harga' => 'float',
        'stok'  => 'integer',
    ];

    // Properti OOP dipertahankan untuk class turunan Retail & Konveksi
    protected $name;
    private $price;
    public $sku;

    public function __construct($name = [], $price = null, $sku = null)
    {
        if (is_array($name)) {
            parent::__construct($name);
            return;
        }

        parent::__construct();
        $this->name = $name;
        $this->price = $price;
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name ?? $this->nama;
    }

    public function getPrice()
    {
        return $this->price ?? $this->harga;
    }

    public function __toString()
    {
        $nama = $this->getName();
        $sku = $this->sku ?? ('PRD-' . $this->id);
        return "Produk: {$nama} (SKU: {$sku})";
    }
}
