<?php
// File: module/home/index.php

// Instance objek (Database sudah di-instance di index.php utama)
// Instance Form dengan action ke home/index
$form = new Form(BASE_URL . 'home/index', "Simpan Data"); 

// Definisikan Field Form
$form->addField("nama", "Nama Lengkap");
$form->addField("email", "Email");
$form->addField("pass", "Password", "password");
$form->addField("jenis_kelamin", "Jenis Kelamin", "radio", [
    'L' => 'Laki-laki',
    'P' => 'Perempuan'
]);
$form->addField("agama", "Agama", "select", [
    'Islam' => 'Islam', 'Kristen' => 'Kristen', 'Katolik' => 'Katolik',
    'Hindu' => 'Hindu', 'Budha' => 'Budha'
]);
$form->addField("hobi", "Hobi", "checkbox", [
    'Membaca' => 'Membaca', 'Coding' => 'Coding', 'Traveling' => 'Traveling'
]);
$form->addField("alamat", "Alamat Lengkap", "textarea");

// Logika penyimpanan data jika tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data POST
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['pass'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $agama = $_POST['agama'] ?? '';
    $hobi_array = $_POST['hobi'] ?? [];
    $alamat = trim($_POST['alamat'] ?? '');
    
    // Konversi Hobi (array) menjadi string dipisahkan koma
    $hobi = is_array($hobi_array) ? implode(',', $hobi_array) : ''; 

    // Set nilai form kembali (untuk mempertahankan input user)
    $form->setFieldValue('nama', $nama);
    $form->setFieldValue('email', $email);
    $form->setFieldValue('jenis_kelamin', $jenis_kelamin);
    $form->setFieldValue('agama', $agama);
    $form->setFieldValue('hobi', $hobi_array); // Berikan array untuk checkbox
    $form->setFieldValue('alamat', $alamat);


    // Validasi sederhana
    if (empty($nama) || empty($email) || empty($pass)) {
        echo "<div style='color:red'>Error: Nama, Email, dan Password wajib diisi!</div>";
    } else {
        // Siapkan data
        $data = [
            'nama' => $nama,
            'email' => $email,
            'pass' => password_hash($pass, PASSWORD_DEFAULT), // Gunakan hash password yang aman
            'jenis_kelamin' => $jenis_kelamin,
            'agama' => $agama,
            'hobi' => $hobi,
            'alamat' => $alamat,
        ];

        // Lakukan insert
        $simpan = $db->insert('users', $data);
        if ($simpan) {
            // Setelah berhasil simpan, reset nilai form
            $form = new Form(BASE_URL . 'home/index', "Simpan Data"); // Buat instance baru untuk form kosong
            echo "<div style='color:green'>Data berhasil disimpan!</div>";
        } else {
            echo "<div style='color:red'>Gagal menyimpan data ke database.</div>";
        }
    }
}
?>

<h2>Form Input User (Contoh Penggunaan Class Form)</h2>
<?php
// Tampilkan Form
$form->displayForm();
?>
