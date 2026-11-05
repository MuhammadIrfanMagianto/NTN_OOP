<?php
// api_products.php  (Entry point JSON -> ProductController)
require_once __DIR__ . '/autoload.php';

use NTNIndustries\Controller\ProductController;

$controller = new ProductController();
$controller->api();
