<?php
// auth.php  (Entry point -> AuthController)
require_once __DIR__ . '/autoload.php';

use NTNIndustries\Controller\AuthController;

$controller = new AuthController();
$controller->index();
