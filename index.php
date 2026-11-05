<?php
// index.php  (Entry point -> HomeController)
require_once __DIR__ . '/autoload.php';

use NTNIndustries\Controller\HomeController;

$controller = new HomeController();
$controller->index();
