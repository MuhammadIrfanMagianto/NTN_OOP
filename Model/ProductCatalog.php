<?php
// Model/ProductCatalog.php
// Model yang mengelola DATA produk (Data + Data Access).
// Sebelumnya data ini tersebar di index.php dan api_products.php.
namespace NTNIndustries\Model;

class ProductCatalog {

    // Data produk Retail & Konveksi untuk halaman utama (dulu ada di index.php)
    public function getFeaturedItems() {
        return [
            'tshirt'       => new Retail("T-Shirt NTN Gang", 150000, "NTN-TS-001", "Limited Stock"),
            'hoodie'       => new Retail("Hoodie NTN Gang", 350000, "NTN-HD-005", "In Stock"),
            'jasaKonveksi' => new Konveksi("Jasa Produksi Jaket Custom", 5000000, "NTN-SVC-01", 30),
            'jasaPolo'     => new Konveksi("Jasa Produksi Polo Shirt", 1500000, "NTN-SVC-02", 50),
        ];
    }

    // ------------------------------------------------------------------
    // API PRODUK NTN INDUSTRIES (dipakai api_products.php)
    //   type     : "retail" (NTN Fashion) atau "konveksi" (jasa produksi)
    //   price    : rupiah (IDR). Konveksi = harga estimasi per paket/order
    //   stock    : khusus retail   |   min_order : khusus konveksi
    // ------------------------------------------------------------------
    private function getApiData() {
        return [
            [
                "id" => 1,
                "sku" => "NTN-TS-001",
                "title" => "NTN Ambition T-Shirt",
                "type" => "retail",
                "category" => "NTN Retail Fashion",
                "price" => 150000,
                "currency" => "IDR",
                "description" => "Kaos signature NTN Gang, cotton combed 30s, desain minimalis dan nyaman dipakai harian.",
                "image" => "src/gambar/ntntshirt.jpg",
                "stock" => "Limited Stock",
                "rating" => ["rate" => 4.5, "count" => 120]
            ],
            [
                "id" => 2,
                "sku" => "NTN-HD-005",
                "title" => "NTN Gang Hoodie",
                "type" => "retail",
                "category" => "NTN Retail Fashion",
                "price" => 350000,
                "currency" => "IDR",
                "description" => "Hoodie fleece tebal bergaya street wear, cocok untuk nongkrong dan touring malam.",
                "image" => "src/gambar/ntnhoodie.jpg",
                "stock" => "In Stock",
                "rating" => ["rate" => 4.8, "count" => 95]
            ],
            [
                "id" => 3,
                "sku" => "NTN-PL-003",
                "title" => "Jersey Polo Racing",
                "type" => "retail",
                "category" => "NTN Retail Fashion",
                "price" => 250000,
                "currency" => "IDR",
                "description" => "Jersey polo ringan bertema racing, desain sporty untuk balap dan hangout.",
                "image" => "src/gambar/ntnpolo.jpg",
                "stock" => "In Stock",
                "rating" => ["rate" => 4.2, "count" => 50]
            ],
            [
                "id" => 4,
                "sku" => "NTN-SVC-01",
                "title" => "Jasa Produksi Jaket Custom",
                "type" => "konveksi",
                "category" => "Jasa Konveksi",
                "price" => 5000000,
                "currency" => "IDR",
                "description" => "Produksi jaket custom untuk komunitas, tim balap, dan perusahaan. Sablon/bordir presisi.",
                "image" => "",
                "min_order" => 30,
                "rating" => ["rate" => 5.0, "count" => 15]
            ],
            [
                "id" => 5,
                "sku" => "NTN-SVC-02",
                "title" => "Jasa Produksi Polo Shirt",
                "type" => "konveksi",
                "category" => "Jasa Konveksi",
                "price" => 1500000,
                "currency" => "IDR",
                "description" => "Produksi polo shirt seragam untuk brand, komunitas, dan perusahaan dengan MOQ fleksibel.",
                "image" => "",
                "min_order" => 50,
                "rating" => ["rate" => 4.9, "count" => 22]
            ]
        ];
    }

    // Semua produk, atau difilter berdasarkan type ("retail" / "konveksi")
    public function getApiProducts($type = null) {
        $products = $this->getApiData();

        if ($type !== null && $type !== '') {
            $products = array_values(array_filter($products, function ($p) use ($type) {
                return $p['type'] === $type;
            }));
        }

        return $products;
    }

    // Satu produk berdasarkan id (null jika tidak ada)
    public function findApiProduct($id) {
        foreach ($this->getApiData() as $p) {
            if ($p['id'] === (int) $id) {
                return $p;
            }
        }
        return null;
    }
}
