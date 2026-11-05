<?php
// autoload.php
// Autoloader untuk struktur MVC: NTNIndustries\Model\* -> Model/*.php
//                                NTNIndustries\Controller\* -> Controller/*.php

spl_autoload_register(function ($class) {
    $prefix = 'NTNIndustries\\';

    // Abaikan class di luar namespace aplikasi
    if (strpos($class, $prefix) !== 0) {
        return;
    }

    // NTNIndustries\Model\Retail  ->  Model\Retail
    $relative = substr($class, strlen($prefix));

    // Susun path absolut (konsisten untuk Laragon/Windows)
    $file = __DIR__ . DIRECTORY_SEPARATOR . $relative . '.php';
    $file = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file);

    if (file_exists($file)) {
        require $file;
    } else {
        throw new \Exception("Autoload Error: Gagal menemukan file di path: " . $file);
    }
});
