<?php
// File: module/artikel/ubah.php
// $id diambil dari router (index.php)
$id_artikel = (int)($segments[2] ?? 0); // Ambil segmen ke-3 (id)
if (!$id_artikel) {
    echo '<div style="color:red;">Error: ID Artikel tidak ditemukan.</div>';
    return;
}

$error = '';

// 1. Ambil Data Artikel Lama
$artikel = $db->get('artikel', "id = $id_artikel");

if (!$artikel) {
    echo '<div style="color:red;">Artikel dengan ID ' . $id_artikel . ' tidak ditemukan.</div>';
    return;
}

$judul_lama = $artikel['judul'];
$isi_lama = $artikel['isi'];

// Instance Form, action ke halaman yang sama (BASE_URL . 'artikel/ubah/ID')
$form = new Form(BASE_URL . 'artikel/ubah/' . $id_artikel, "Simpan Perubahan");

// Definisikan Field Form
$form->addField("judul", "Judul Artikel"); 
$form->addField("isi", "Isi Artikel", "textarea");

// Set nilai awal form dari database
$form->setFieldValue('judul', $judul_lama);
$form->setFieldValue('isi', $isi_lama);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. Proses Update
    $judul_baru = trim($_POST['judul'] ?? '');
    $isi_baru = trim($_POST['isi'] ?? '');
    
    if (empty($judul_baru) || empty($isi_baru)) {
        $error = 'Judul dan Isi artikel wajib diisi.';
    } else {
        // 3. Siapkan data untuk update
        $data = [
            'judul' => $judul_baru,
            'isi' => $isi_baru
            // Tanggal dibuat tidak diubah, bisa ditambahkan tanggal_diubah jika perlu
        ];
        
        // 4. Update ke database
        $simpan = $db->update('artikel', $data, "id = $id_artikel"); 

        if ($simpan) { 
            $_SESSION['flash_message'] = "Artikel ID $id_artikel berhasil diubah!";
            header('Location: ' . BASE_URL . 'artikel');
            exit;
        } else { 
            $error = 'Gagal mengubah data.';
        }
    }

    // Jika ada error, set nilai form dengan input POST agar tidak hilang
    if ($error) {
        $form->setFieldValue('judul', $judul_baru);
        $form->setFieldValue('isi', $isi_baru);
    }
}
?>

<h2>Ubah Artikel ID: <?= $id_artikel ?></h2>
<?php if ($error): ?>
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px; background-color: #fff0f0;"><?= $error ?></div>
<?php endif; ?>

<?php
// Tampilkan Form
$form->displayForm();
?>
<p><a href="<?= BASE_URL ?>artikel" class="btn">Batal</a></p>
