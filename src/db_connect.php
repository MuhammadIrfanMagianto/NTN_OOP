<?php
// src/db_connect.php

// Laporkan error MySQLi sebagai exception (konsisten di semua versi PHP)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// --- Kredensial Database (Laragon Default) ---
$host = 'localhost';
$username = 'root';
$password = ''; 
$dbname = 'ntn_db'; // Database dibuat otomatis jika belum ada

try {
    // Buat koneksi MySQLi
    $conn = new mysqli($host, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    // Error 1049 = database belum ada -> buat otomatis, lalu sambungkan lagi
    if ($e->getCode() === 1049) {
        $setup = new mysqli($host, $username, $password);
        $setup->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $setup->close();

        $conn = new mysqli($host, $username, $password, $dbname);
    } else {
        // Gagal konek (misal MySQL belum nyala): lempar ke Controller agar ditampilkan rapi
        throw $e;
    }
}

$conn->set_charset('utf8mb4');
