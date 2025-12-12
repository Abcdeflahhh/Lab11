# 🌑 **Project Title — LAB11_PHP_OOP**
### 👨‍💻 *Aflah Athalah Tamam Kapukong | Developer & Tech Explorer*

<p align="left">
  <!-- Python -->
  <img src="https://img.shields.io/badge/Python-000000?style=for-the-badge&logo=python&logoColor=yellow" />

  <!-- XAMPP -->
  <img src="https://img.shields.io/badge/XAMPP-000000?style=for-the-badge&logo=xampp&logoColor=orange" />

  <!-- GitHub -->
  <img src="https://img.shields.io/badge/GitHub-000000?style=for-the-badge&logo=github&logoColor=white" />
</p>

🚀 Overview

Repository ini berisi implementasi praktikum Pemrograman Web terkait konsep Object Oriented Programming (OOP) di PHP.
Project dibuat dengan pendekatan profesional, terstruktur, dan modular menggunakan class library untuk:

🔹 Class & Object

🔹 Constructor & Encapsulation

🔹 Form Builder OOP

🔹 Database Handler (MySQL)

🔹 Modular Architecture

Semua kode berjalan pada lingkungan XAMPP dan ditulis menggunakan VSCode.

# 📂 Project Structure

📁 lab11_php_oop/
│── .htaccess/
│── config.php/
│── index.php/
└── class/
│── │── database.php/
│── │── form.php/
└── module/
│── │── artikel/
│── │── │── index.php/
│── │── │── tambah.php/
│── │── │── ubah.php/
└── template/
│── │── header.php/
│── │── footer.php/
│── │── sidebar.php/
└── screenshots/
│── │── Img/
│── │── │── gambar/

### 🧠 Concepts Implemented

✅ 1. Class & Object

✅ 2. Class Library

✅ 3. Modular Architecture

✅ 4. Database Handler

### Class database menangani: 

* Koneksi MySQL

 * Query

* Insert

* Get *

### Tujuan :

1. Mahasiswa mampu memahami konsep dasar Framework Modular.
2. Mahasiswa mampu memahami konsep dasar routing.
3. Mahasaswa mampu membuat Framework sederhana menggunakan PHP OOP.

### Instruksi Praktikum :

1. Persiapkan text editor misalnya VSCode.
2. Buat folder baru dengan nama lab11_php_oop pada docroot webserver (htdocs)
3. Ikuti langkah-langkah praktikum yang akan dijelaskan berikutnya

## Langkah-langkah Praktikum :

### A. Persiapan Struktur Folder

* Langkah 1: Pindahkan file Database.php dan Form.php (dari praktikum sebelumnya) ke 
dalam folder class/. 

File form.php :
```
<?php
// File: class/Form.php
class Form
{
    private $fields = array();
    private $action;
    private $submit = "Submit Form";
    private $jumField = 0;

    public function __construct($action, $submit)
    {
        $this->action = $action;
        $this->submit = $submit;
    }
    
    // Method baru: Menetapkan nilai field
    public function setFieldValue($name, $value)
    {
        foreach ($this->fields as $key => $field) {
            if ($field['name'] === $name) {
                $this->fields[$key]['value'] = $value;
                return;
            }
        }
    }

    public function displayForm()
    {
        echo "<form action='" . htmlspecialchars($this->action) . "' method='POST'>";
        echo '<table width="100%" border="0">';
        
        foreach ($this->fields as $field) {
            $name = htmlspecialchars($field['name']);
            $label = htmlspecialchars($field['label']);
            $type = $field['type'];
            // Nilai saat ini (jika ada, default kosong)
            $current_value = $field['value'] ?? ''; 
            
            echo "<tr><td align='right' valign='top'>" . $label . 
            "</td>";
            echo "<td>";
            
            switch ($type) {
                case 'textarea':
                    echo "<textarea name='" . $name . "' cols='30' 
                    rows='4'>" . htmlspecialchars($current_value) . "</textarea>";
                    break;
                case 'select':
                    echo "<select name='" . $name . "'>";
                    foreach ($field['options'] as $value => $label) {
                        $selected = ($current_value == $value) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($value) . "' $selected>" . htmlspecialchars($label) . 
                        "</option>";
                    }
                    echo "</select>";
                    break;
                case 'radio':
                    foreach ($field['options'] as $value => $label) {
                        $checked = ($current_value == $value) ? 'checked' : '';
                        echo "<label><input type='radio' name='" . $name . "' value='" . htmlspecialchars($value) . "' $checked> " . htmlspecialchars($label) . "</label> ";
                    }
                    break;
                case 'checkbox':
                    // Untuk checkbox group, nilai saat ini mungkin berupa array atau string
                    $current_values = is_array($current_value) ? $current_value : explode(',', $current_value);
                    foreach ($field['options'] as $value => $label) {
                        // Periksa apakah value ada di array current_values
                        $checked = in_array($value, $current_values) ? 'checked' : '';
                        // Untuk checkbox group, nama field ditambah []
                        echo "<label><input type='checkbox' name='" . $name . "[]' value='" . htmlspecialchars($value) . "' $checked> " . htmlspecialchars($label) . "</label> ";
                    }
                    break;
                case 'password':
                    // Password tidak perlu diisi ulang untuk keamanan
                    echo "<input type='password' name='" . $name . "'>";
                    break;
                default: // Defaultnya adalah text input biasa
                    echo "<input type='text' name='" . $name . "' value='" . htmlspecialchars($current_value) . "'>";
                    break;
            }
            echo "</td></tr>";
        }
        
        echo "<tr><td colspan='2'>";
        echo "<input type='submit' value='" . htmlspecialchars($this->submit) . "'></td></tr>";
        echo "</table>";
        echo "</form>";
    }

    /**
    * addField
    * @param string $name Nama atribut (name="")
    * @param string $label Label untuk field
    * @param string $type Tipe input (text, textarea, select, radio, checkbox, 
    password)
    * @param array $options Opsi untuk select/radio/checkbox (format: 
    ['value' => 'Label'])
    */
    public function addField($name, $label, $type = "text", $options = 
    array())
    {
        $this->fields[$this->jumField]['name'] = $name;
        $this->fields[$this->jumField]['label'] = $label;
        $this->fields[$this->jumField]['type'] = $type;
        $this->fields[$this->jumField]['options'] = $options;
        // Inisialisasi nilai awal
        $this->fields[$this->jumField]['value'] = ''; 
        $this->jumField++;
    }
}
?>
```

File database.php :
```
<?php
// File: class/Database.php
class Database
{
    protected $host;
    protected $user;
    protected $password;
    protected $db_name;
    protected $conn;

    public function __construct()
    {
        $this->getConfig();
        // Menggunakan koneksi mysqli
        $this->conn = new mysqli($this->host, $this->user, $this->password, 
        $this->db_name);
        
        if ($this->conn->connect_error) {
            // Hentikan eksekusi jika koneksi gagal
            die("Koneksi Database gagal: " . $this->conn->connect_error);
        }
    }

    private function getConfig()
    {
        // Path relatif ke config.php dari class/Database.php 
        // Sebaiknya getConfig() dipanggil dari root index.php, tapi akan disesuaikan dengan struktur Anda.
        // Di sini menggunakan CONFIG_PATH dari index.php yang sudah di-include.
        if (defined('CONFIG_PATH') && file_exists(CONFIG_PATH)) {
            include CONFIG_PATH; 
        } else {
             // Fallback atau error jika CONFIG_PATH tidak terdefinisi
             die("Error: Konfigurasi tidak dapat dimuat. Pastikan CONFIG_PATH didefinisikan.");
        }
        
        $this->host = $config['host'];
        $this->user = $config['username'];
        $this->password = $config['password'];
        $this->db_name = $config['db_name'];
    }

    // Method untuk eksekusi query SQL biasa
    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    // Method untuk SELECT satu baris data (fetch_assoc)
    public function get($table, $where = null)
    {
        if ($where) {
            $where_clause = " WHERE " . $where;
        } else {
            $where_clause = "";
        }
        $sql = "SELECT * FROM " . $table . $where_clause . " LIMIT 1"; // Tambah LIMIT 1
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null; // Mengembalikan null jika tidak ada data
    }
    
    // Method baru: untuk SELECT semua baris data (fetchAll)
    public function fetchAll($sql)
    {
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function insert($table, $data)
    {
        $column = [];
        $value = [];
        
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $column[] = $key;
                // Selalu gunakan real_escape_string untuk mencegah SQL Injection
                $sanitized_val = $this->conn->real_escape_string($val); 
                $value[] = "'{$sanitized_val}'"; 
            }
            $columns = implode(",", $column);
            $values = implode(",", $value);
        } else {
            return false; // Gagal jika data bukan array
        }
        
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values. ")";
        $result = $this->conn->query($sql);
        
        // Mengembalikan boolean hasil query
        return $result;
    }

    public function update($table, $data, $where)
    {
        if (!$where) {
            return false; // Wajib ada klausa WHERE
        }
        
        $update_value = [];
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                // Selalu gunakan real_escape_string untuk keamanan
                $sanitized_val = $this->conn->real_escape_string($val);
                $update_value[] = "$key='{$sanitized_val}'"; 
            }
            $update_value = implode(",", $update_value);
        } else {
            return false; // Gagal jika data bukan array
        }
        
        $sql = "UPDATE " . $table . " SET " . $update_value . " WHERE " . $where;
        $result = $this->conn->query($sql);
        
        // Mengembalikan boolean hasil query
        return $result;
    }
    
    // Method baru: untuk DELETE data
    public function delete($table, $where)
    {
        if (!$where) {
            return false; // Wajib ada klausa WHERE
        }
        
        $sql = "DELETE FROM " . $table . " WHERE " . $where;
        $result = $this->conn->query($sql);
        
        return $result;
    }
}
?>
```

### B. Konfigurasi Dasar

File: config.php Sesuaikan dengan database anda
```
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
```

### Tugas & Implementasi 

Implementasikan konsep modularisasi dari praktikum sebelumnya dan terapkan konsep 
routing pada project yang baru : 

#### Contoh Implementasi (Gabungan Form dan Simpan Data) :
```
<?php
// FILE: index.php atau file utama form

// --- Konfigurasi dan Inklusi ---
// Sertakan library (asumsi kelas Form dan Database didefinisikan di sini)
include "form.php";
include "database.php";

// --- Inisialisasi Objek ---
$db = new Database();
// Instance objek Form. Action kosong ("") berarti submit ke halaman yang sama.
$form = new Form("", "Simpan Data"); 

// --- Logika Pemrosesan Data (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitisasi input sederhana sebelum disimpan (sangat disarankan)
    $nama  = isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    // Password biasanya perlu di-hash sebelum disimpan (hanya contoh sederhana)
    $pass  = isset($_POST['pass']) ? $_POST['pass'] : ''; 
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
    $agama = isset($_POST['agama']) ? $_POST['agama'] : '';
    // Hobi adalah array dari checkbox, gabungkan menjadi string (atau simpan sebagai JSON)
    $hobi = isset($_POST['hobi']) ? implode(', ', (array)$_POST['hobi']) : '';
    $alamat = isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '';
    
    // Data yang akan disimpan ke database
    $data = [
        'nama'          => $nama,
        'email'         => $email,
        'pass'          => $pass, // PENTING: Dalam aplikasi nyata, gunakan password_hash()
        'jenis_kelamin' => $jenis_kelamin,
        'agama'         => $agama,
        'hobi'          => $hobi,
        'alamat'        => $alamat,
    ];

    // Simpan ke tabel 'users' (asumsi method insert() ada pada kelas Database)
    $simpan = $db->insert('users', $data);

    // Tampilkan pesan hasil penyimpanan
    if ($simpan) {
        echo "<div style='color:green; padding: 10px; border: 1px solid green; background: #e6ffe6;'>
                ✅ Data **berhasil** disimpan!
              </div>";
    } else {
        echo "<div style='color:red; padding: 10px; border: 1px solid red; background: #ffe6e6;'>
                ❌ Gagal menyimpan data. Silakan coba lagi.
              </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum 10 - Form Input User (OOP)</title>
    <style>
        /* CSS Sederhana untuk tampilan yang lebih baik */
        body { font-family: Arial, sans-serif; margin: 20px; }
        h3 { border-bottom: 2px solid #ccc; padding-bottom: 5px; }
        /* Tambahkan style jika diperlukan, tergantung implementasi kelas Form */
    </style>
</head>
<body>

    <h3>📝 Form Input User (OOP)</h3>

    <?php
    // --- Definisi Field Form ---
    
    // 1. Input Text Biasa
    $form->addField("nama", "Nama Lengkap", "text"); // Tipe default 'text' bisa diabaikan, tapi lebih jelas
    $form->addField("email", "Email", "email"); // Menggunakan tipe 'email' untuk validasi browser
    
    // 2. Input Password (Tipe baru)
    $form->addField("pass", "Password", "password");
    
    // 3. Input Radio Button (Single selection)
    // Parameter ke-4 adalah array pilihan: 'value' => 'Label yang muncul'
    $form->addField("jenis_kelamin", "Jenis Kelamin", "radio", [
        'L' => 'Laki-laki',
        'P' => 'Perempuan'
    ]);
    
    // 4. Input Select / Dropdown
    $form->addField("agama", "Agama", "select", [
        ''        => '-- Pilih Agama --', // Opsi default
        'Islam'   => 'Islam',
        'Kristen' => 'Kristen',
        'Katolik' => 'Katolik',
        'Hindu'   => 'Hindu',
        'Budha'   => 'Budha'
    ]);
    
    // 5. Input Checkbox (Multi selection)
    // Penting: Kelas Form harus menangani nama input sebagai array (e.g., name="hobi[]")
    $form->addField("hobi", "Hobi", "checkbox", [
        'Membaca'   => 'Membaca',
        'Coding'    => 'Coding',
        'Traveling' => 'Traveling'
    ]);
    
    // 6. Input Textarea
    $form->addField("alamat", "Alamat Lengkap", "textarea");
    
    // --- Tampilkan Form ---
    $form->displayForm();
    ?>

    <p>
        <small>* Pastikan file `form.php` dan `database.php` tersedia dan berisi implementasi kelas yang benar.</small>
    </p>
    
</body>
</html>
```

### Contoh Routing :

File: .htaccess File ini penting agar URL localhost/lab11/artikel/index bisa dibaca oleh 
server. Buat file baru bernama .htaccess (tanpa nama depan, hanya ekstensi).

```
<IfModule mod_rewrite.c>
    # Aktifkan RewriteEngine
    RewriteEngine On
    
    # 1. Sesuaikan RewriteBase dengan nama folder project kamu di htdocs
    # Jika project kamu diakses melalui http://localhost/lab11_php_oop/
    RewriteBase /lab11_php_oop/
    
    # --- Kondisi (Conditions) ---
    
    # 2. Jangan proses Rewrite jika file aslinya (misal: style.css) memang ada
    RewriteCond %{REQUEST_FILENAME} !-f
    
    # 3. Jangan proses Rewrite jika folder aslinya (misal: /assets/) memang ada
    RewriteCond %{REQUEST_FILENAME} !-d
    
    # --- Rule (Aturan Pengalihan) ---
    
    # 4. Arahkan semua request lain ke index.php
    # ^(.*)$ menangkap seluruh sisa URL setelah RewriteBase
    # index.php/$1 mengarahkan request ke index.php dengan sisa URL sebagai parameter path
    # [L] menandakan ini adalah rule terakhir (Last) yang diproses
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

File: index.php

```
<?php
// FILE: index.php (Front Controller)

// --- I. SETUP APLIKASI ---

// Load konfigurasi dan helper jika ada
// Asumsi: config.php berisi variabel global atau konstanta.
include "config.php"; 

// Kita perlu autoloader atau include manual class
// Dalam aplikasi besar, gunakan Composer Autoloader.
// Untuk contoh ini, kita menggunakan include manual.
include "class/Database.php";
include "class/Form.php"; 

// Mulai Session (penting untuk login, data sementara, atau flash message)
session_start();

// --- II. LOGIKA ROUTING ---

// Menangkap request path. 
// $path_info didapatkan dari .htaccess (RewriteRule ^(.*)$ index.php/$1 [L])
// Gunakan '/home/index' sebagai path default jika tidak ada PATH_INFO
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/home/index';

// Membersihkan path: Menghapus slash di awal dan akhir, lalu memecah string menjadi array
// Contoh: '/artikel/tambah/' -> ['artikel', 'tambah']
$segments = explode('/', trim($path, '/'));

// Menentukan Module (Controller)
// Ambil segmen pertama. Jika kosong, default ke 'home'.
$mod = !empty($segments[0]) ? $segments[0] : 'home';

// Menentukan Action/Page (Method)
// Ambil segmen kedua. Jika kosong, default ke 'index'.
$page = !empty($segments[1]) ? $segments[1] : 'index';

// Menentukan path file modul yang akan dimuat
// Asumsi: Struktur file modul berada di 'module/MODUL_NAMA/HALAMAN_NAMA.php'
$file = "module/{$mod}/{$page}.php";

// 

// --- III. LOAD TEMPLATE & KONTEN ---

// 1. Load Header Template (Berisi HTML pembuka, navigasi, dll.)
include "template/header.php";

// 2. Load Konten Utama (Modul/Halaman)
// Cek apakah file modul yang dituju ada
if (file_exists($file)) {
    // Muat dan jalankan logika modul/halaman yang sesuai
    include $file;
} else {
    // Tampilkan pesan error 404 sederhana jika file modul tidak ditemukan
    // Gunakan class CSS Bootstrap/lainnya untuk pesan error
    echo '<div class="alert alert-danger" style="padding: 15px; border: 1px solid #ebccd1; background-color: #f2dede; color: #a94442;">';
    echo '<h4>❌ Halaman Tidak Ditemukan (Error 404)</h4>';
    echo 'Modul tidak ditemukan: <code>' . htmlspecialchars($mod . '/' . $page) . '</code>';
    echo '</div>';
}

// 3. Load Footer Template (Berisi HTML penutup, script JS, dll.)
include "template/footer.php";

?>
```

### Laporan Praktikum

1. Buatlah repository baru dengan nama Lab11Web.
2. Kerjakan semua latihan yang diberikan sesuai urutannya.
3. Screenshot setiap perubahannya.
4. Buatlah file README.md dan tuliskan penjelasan dari setiap langkah praktikum 
beserta screenshotnya.
5. Commit hasilnya pada repository masing-masing.
6. Kirim URL repository pada e-learning ecampus



#### 🚀 How to Run

1. Aktifkan Apache & MySQL di XAMPP

2. Pindahkan project ke:

C:/xampp/htdocs/lab11_php_oop/

3. Buat database:

phpMyAdmin → Create DB: lab10web

4. Jalankan:

http://localhost/lab11_php_oop/

#### Pada praktikum ini, kamu telah mempelajari:

* Fondasi OOP pada PHP

* Pembuatan class, object, constructor

* Penerapan library untuk form

* Koneksi database menggunakan class

* Modularisasi program profesional

* Struktur project yang rapi memudahkan pengembangan di masa depan.

🤝 Contact

Jika ingin mengembangkan atau menambah fitur, silakan reach out!

📧 Email : aflahtamam@example.com

🐙 GitHub : https://github.com/AflahTamam

<p align="left">
  <!-- Python -->
  <img src="https://img.shields.io/badge/Python-000000?style=for-the-badge&logo=python&logoColor=yellow" />

  <!-- XAMPP -->
  <img src="https://img.shields.io/badge/XAMPP-000000?style=for-the-badge&logo=xampp&logoColor=orange" />

  <!-- GitHub -->
  <img src="https://img.shields.io/badge/GitHub-000000?style=for-the-badge&logo=github&logoColor=white" />
</p>
