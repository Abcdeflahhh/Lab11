<?php
// File: config.php

// Konfigurasi Database
$config = [
    'host' => 'localhost',
    'username' => 'root', 
    'password' => '',     
    'db_name' => 'lab11_php_oop', 
];

// Konstanta URL Dasar
// Pastikan ini sesuai dengan struktur direktori web server Anda
// Gunakan defined() untuk mencegah error jika file ini di-include lebih dari sekali.
if (!defined('BASE_URL')) {
    define('BASE_URL', '/lab11_php_oop/');
}

?>
