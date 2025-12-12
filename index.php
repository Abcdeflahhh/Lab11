<?php
// File: index.php

// 1. Definisikan Konstanta Path
// __DIR__ memberikan direktori dari file saat ini (lab11_php_oop/)
define('ROOT_PATH', __DIR__ . '/');
define('CLASS_PATH', ROOT_PATH . 'class/');
define('CONFIG_PATH', ROOT_PATH . 'config.php');
define('MODULE_PATH', ROOT_PATH . 'module/');
define('TEMPLATE_PATH', ROOT_PATH . 'template/');

// 2. Load Konfigurasi (Termasuk BASE_URL)
if (!file_exists(CONFIG_PATH)) {
    die("Error: File konfigurasi " . CONFIG_PATH . " tidak ditemukan.");
}
include CONFIG_PATH;

// 3. Include Class Manual
// Pastikan file-file ini ada di folder 'class/'
include CLASS_PATH . "Database.php";
include CLASS_PATH . "Form.php";

// 4. Mulai Session
session_start();

// 5. Instance Database
// Objek $db akan tersedia di semua modul
$db = new Database(); 

// --- ROUTING LOGIC ---
// Menangkap request path. Contoh: /artikel/tambah
// Menggunakan $_SERVER['REQUEST_URI'] dan menghapus BASE_URL
$request_uri = $_SERVER['REQUEST_URI'];
$base_url_len = strlen(BASE_URL);

// Hapus BASE_URL dari REQUEST_URI
if (substr($request_uri, 0, $base_url_len) == BASE_URL) {
    $path = substr($request_uri, $base_url_len);
} else {
    // Fallback jika tidak sesuai BASE_URL
    $path = trim(parse_url($request_uri, PHP_URL_PATH) ?? '', '/');
}

// Menghilangkan parameter query
$path = strtok($path, '?');

// Memecah path menjadi array
$segments = explode('/', trim($path, '/'));

// Menentukan Module (default: home)
$mod = isset($segments[0]) && !empty($segments[0]) ? $segments[0] : 'home';

// Menentukan Action/Page (default: index)
$page = isset($segments[1]) && !empty($segments[1]) ? $segments[1] : 'index';

// Menentukan path file modul
$file = MODULE_PATH . "{$mod}/{$page}.php";

// --- LOAD TEMPLATE & KONTEN ---

// Load Header
include TEMPLATE_PATH . "header.php";

// Cek apakah file modul ada
if (file_exists($file)) {
    // Di sini, variabel $db sudah tersedia untuk digunakan di modul
    // Variabel $segments juga tersedia untuk mengambil ID di modul hapus/ubah
    include $file;
} else {
    // Jika modul tidak ditemukan
    echo '<div class="alert alert-danger">Modul tidak ditemukan: ' . htmlspecialchars($mod) . 
    '/' . htmlspecialchars($page) . '</div>';
    // Load modul 404 jika ada
}

// Load Footer
include TEMPLATE_PATH . "footer.php";

?>
