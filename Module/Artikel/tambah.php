<?php
// File: module/artikel/tambah.php
$error = '';
$judul = '';
$isi = '';

// Instance Form, action ke halaman yang sama (BASE_URL . 'artikel/tambah')
$form = new Form(BASE_URL . 'artikel/tambah', "Simpan Artikel");

// Definisikan Field Form
$form->addField("judul", "Judul Artikel"); // Default type text
$form->addField("isi", "Isi Artikel", "textarea"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // 1. Ambil data POST
    $judul = trim($_POST['judul'] ?? '');
    $isi = trim($_POST['isi'] ?? '');
    
    if (empty($judul) || empty($isi)) {
        $error = 'Judul dan Isi artikel wajib diisi.';
    } else {
        // 2. Siapkan data untuk insert
        $data = [
            'judul' => $judul,
            'isi' => $isi,
            'tanggal_dibuat' => date('Y-m-d H:i:s') // Tambahkan timestamp
        ];
        
        // 3. Simpan ke database
        $simpan = $db->insert('artikel', $data); 

        if ($simpan) { 
            $_SESSION['flash_message'] = "Artikel berhasil ditambahkan!";
            header('Location: ' . BASE_URL . 'artikel');
            exit;
        } else { 
            // Tambahkan error DB untuk debugging
            $error = 'Gagal menyimpan data ke database. Silakan coba lagi.';
        }
    }
}
?>

<h2>Tambah Artikel Baru</h2>
<?php if ($error): ?>
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px; background-color: #fff0f0;"><?= $error ?></div>
<?php endif; ?>

<?php
// Jika ada error atau post, set nilai form kembali agar data tidak hilang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form->setFieldValue('judul', $judul);
    $form->setFieldValue('isi', $isi);
}

// Tampilkan Form 
$form->displayForm();
?>
