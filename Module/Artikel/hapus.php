<?php
// File: module/artikel/hapus.php
// $segments[2] adalah ID artikel dari router
$id_artikel = (int)($segments[2] ?? 0); 

if (!$id_artikel) {
    $_SESSION['flash_message'] = "Error: ID Artikel tidak valid untuk dihapus.";
    header('Location: ' . BASE_URL . 'artikel');
    exit;
}

// Proses penghapusan menggunakan method delete yang baru ditambahkan
$result = $db->delete('artikel', "id = $id_artikel");

if ($result) {
    $_SESSION['flash_message'] = "Artikel ID $id_artikel berhasil dihapus!";
} else {
    $_SESSION['flash_message'] = "Gagal menghapus artikel ID $id_artikel.";
}

// Redirect kembali ke halaman daftar artikel
header('Location: ' . BASE_URL . 'artikel');
exit;
?>
