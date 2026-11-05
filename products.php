<?php
// products.php  (Entry point -> ProductController)
require_once __DIR__ . '/autoload.php';

use NTNIndustries\Controller\ProductController;

$controller = new ProductController();
$controller->index();
