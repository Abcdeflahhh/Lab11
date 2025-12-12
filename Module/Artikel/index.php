<?php
// File: module/artikel/index.php

// Query untuk mengambil semua artikel. Menggunakan method fetchAll yang baru ditambahkan
$sql = "SELECT id, judul, tanggal_dibuat FROM artikel ORDER BY id DESC";
$artikels = $db->fetchAll($sql); 
?>

<h2>Daftar Artikel</h2>
<p><a href="<?= BASE_URL ?>artikel/tambah" class="btn btn-primary">Tambah Artikel Baru</a></p>

<?php 
// Tampilkan flash message
if (isset($_SESSION['flash_message'])): ?>
    <p style="color: green; border: 1px solid green; padding: 10px; background-color: #e9ffe9;"><?= $_SESSION['flash_message'] ?></p>
    <?php unset($_SESSION['flash_message']);
endif; ?>

<table border="1" style="width: 100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Tanggal Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (!empty($artikels)):
            foreach ($artikels as $artikel): ?>
            <tr>
                <td><?= $artikel['id'] ?></td>
                <td><?= htmlspecialchars($artikel['judul']) ?></td>
                <td><?= date('d-m-Y H:i', strtotime($artikel['tanggal_dibuat'])) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>artikel/ubah/<?= $artikel['id'] ?>" class="btn btn-primary">Ubah</a>
                    <a href="<?= BASE_URL ?>artikel/hapus/<?= $artikel['id'] ?>" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')" 
                        class="btn btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endforeach; 
        else: ?>
        <tr>
            <td colspan="4">Tidak ada data artikel.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
