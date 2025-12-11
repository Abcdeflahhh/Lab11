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

📂 Project Structure
📁 lab11_php_oop/
│── form.php/
│── form_input.php/
│── database.php/
│── config.php/
│── README.md/
│── index.php/
│── userindex.php/
│── README.md/
└── usertambah.php/
│── userubah.php/
└── screenshots/

🧠 Concepts Implemented
✅ 1. Class & Object

File mobil.php berisi class sederhana dengan constructor, properties, dan method.

✅ 2. Class Library

File form.php digunakan sebagai form builder OOP yang dapat dipanggil oleh file lain.

✅ 3. Modular Architecture

Setiap fitur dipisah ke dalam file berbeda → memudahkan pemeliharaan & pengembangan.

✅ 4. Database Handler

Class database menangani:

#### 1. Koneksi MySQL

#### 2. Query

#### 3. Insert

#### 4. Get 

📌 Config PHP
```
<?php
$config = [
    'host' => 'localhost',
    'username' => 'Aflah Tamam',
    'password' => '886688',
    'db_name' => 'latihan_oop'
];
```

📌 .htaccess
```
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /lab11_php_oop/

    # Jangan proses jika file/folder aslinya memang ada
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f

    # Arahkan semua request lain ke index.php
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

🧩 Main Codes
📌 1. Database PHP
```
<?php
class Database {

    protected $host;
    protected $user;
    protected $password;
    protected $db_name;
    protected $conn;

    public function __construct() {
        $this->getConfig();

        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("DB Error: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
    }

    private function getConfig() {
        include __DIR__ . '/../config.php';

        $this->host = $config['host'];
        $this->user = $config['username'];
        $this->password = $config['password'];
        $this->db_name = $config['db_name'];
    }

    public function fetchAll($sql) {
        $res = $this->conn->query($sql);

        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function insert($table, $data) {
        $cols = implode("`, `", array_keys($data));
        $vals = array_map([$this->conn, 'real_escape_string'], array_values($data));
        $vals = "'" . implode("','", $vals) . "'";

        $sql = "INSERT INTO `$table` (`$cols`) VALUES ($vals)";
        return $this->conn->query($sql);
    }
}
?>
```

📌 2. form.php (Form Builder Class)
```
<?php
class Form {
    private $fields = [];
    private $action;
    private $submit = "Submit Form";
    private $jumField = 0;

    public function __construct($action = "", $submit = "Submit Form") {
        $this->action = $action;
        $this->submit = $submit;
    }

    public function displayForm() {
        echo "<form action='" . $this->action . "' method='POST' enctype='multipart/form-data'>";
        echo '<table width="100%" border="0">';
        foreach ($this->fields as $field) {
            echo "<tr><td align='right' valign='top' style='width:180px;'>" . $field['label'] . "</td>";
            echo "<td>";
            switch ($field['type']) {
                case 'textarea':
                    $val = isset($field['value']) ? htmlspecialchars($field['value']) : '';
                    echo "<textarea name='" . $field['name'] . "' cols='30' rows='4'>{$val}</textarea>";
                    break;
                case 'select':
                    echo "<select name='" . $field['name'] . "'>";
                    foreach ($field['options'] as $value => $label) {
                        $selected = (isset($field['value']) && $field['value'] == $value) ? "selected" : "";
                        echo "<option value='" . htmlspecialchars($value) . "' {$selected}>" . $label . "</option>";
                    }
                    echo "</select>";
                    break;
                case 'radio':
                    foreach ($field['options'] as $value => $label) {
                        $checked = (isset($field['value']) && $field['value'] == $value) ? "checked" : "";
                        echo "<label><input type='radio' name='" . $field['name'] . "' value='" . htmlspecialchars($value) . "' {$checked}> " . $label . "</label> ";
                    }
                    break;
                case 'checkbox':
                    foreach ($field['options'] as $value => $label) {
                        $checked = "";
                        if (isset($field['value']) && is_array($field['value']) && in_array($value, $field['value'])) $checked = "checked";
                        echo "<label><input type='checkbox' name='" . $field['name'] . "[]' value='" . htmlspecialchars($value) . "' {$checked}> " . $label . "</label> ";
                    }
                    break;
                case 'password':
                    echo "<input type='password' name='" . $field['name'] . "'>";
                    break;
                case 'file':
                    echo "<input type='file' name='" . $field['name'] . "'>";
                    break;
                default:
                    $val = isset($field['value']) ? htmlspecialchars($field['value']) : '';
                    echo "<input type='text' name='" . $field['name'] . "' value='{$val}'>";
                    break;
            }
            echo "</td></tr>";
        }
        echo "<tr><td colspan='2' style='text-align:right; padding-top:10px;'><input type='submit' value='" . $this->submit . "'></td></tr>";
        echo "</table>";
        echo "</form>";
    }

    public function addField($name, $label, $type = "text", $options = [], $value = null) {
        $this->fields[$this->jumField]['name'] = $name;
        $this->fields[$this->jumField]['label'] = $label;
        $this->fields[$this->jumField]['type'] = $type;
        $this->fields[$this->jumField]['options'] = $options;
        $this->fields[$this->jumField]['value'] = $value;
        $this->jumField++;
    }
}
```

📌 3. Index PHP
```
<?php
include "config.php";
include "class/Database.php";
include "class/Form.php";

session_start();
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/home/index';
$segments = explode('/', trim($path, '/'));

$mod = isset($segments[0]) && $segments[0] !== '' ? $segments[0] : 'home';
$page = isset($segments[1]) && $segments[1] !== '' ? $segments[1] : 'index';

$file = "module/{$mod}/{$page}.php";

include "template/header.php";
include "template/sidebar.php";

if (file_exists($file)) {
    include $file;
} else {
    echo "<div style='padding:20px;'><h3>Halaman tidak ditemukan: {$mod}/{$page}</h3></div>";
}

include "template/footer.php";
```

📌 4. User Hapus PHP
```
<?php
$db = new Database();
$id = $_GET['id'];

$db->delete("users", "id=$id");

header("Location: /lab11_php_oop/user/index");
exit;
```

📌 5. User Tambah PHP
```
<?php
$db = new Database();
$form = new Form("", "Simpan User");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        'nama' => $_POST['nama'],
        'email' => $_POST['email'],
        'pass' => $_POST['pass'],
        'jenis_kelamin' => $_POST['jenis_kelamin'],
        'agama' => $_POST['agama'],
        'hobi' => isset($_POST['hobi']) ? implode(", ", $_POST['hobi']) : "",
        'alamat' => $_POST['alamat']
    ];

    if ($db->insert("users", $data)) {
        header("Location: /lab11_php_oop/user/index");
        exit;
    } else {
        echo "<p style='color:red;'>Gagal menyimpan user.</p>";
    }
}

$form->addField("nama", "Nama Lengkap");
$form->addField("email", "Email");
$form->addField("pass", "Password", "password");

$form->addField("jenis_kelamin", "Jenis Kelamin", "radio", [
    "L" => "Laki-laki",
    "P" => "Perempuan"
]);

$form->addField("agama", "Agama", "select", [
    "Islam" => "Islam",
    "Kristen" => "Kristen",
    "Katolik" => "Katolik",
    "Hindu" => "Hindu",
    "Budha" => "Budha"
]);

$form->addField("hobi", "Hobi", "checkbox", [
    "Membaca" => "Membaca",
    "Coding" => "Coding",
    "Traveling" => "Traveling"
]);

$form->addField("alamat", "Alamat", "textarea");
?>

<h2>Tambah User</h2>
<?php $form->displayForm(); ?>
```

📌 6. User Index PHP
```
<?php
$db = new Database();
$rows = $db->fetchAll("SELECT * FROM users ORDER BY id DESC");
?>

<h2>Daftar User</h2>
<a class="btn" href="/lab11_php_oop/user/tambah">+ Tambah User</a>

<table>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Jenis Kelamin</th>
        <th>Agama</th>
        <th>Hobi</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['nama']); ?></td>
            <td><?= htmlspecialchars($u['email']); ?></td>
            <td><?= htmlspecialchars($u['jenis_kelamin']); ?></td>
            <td><?= htmlspecialchars($u['agama']); ?></td>
            <td><?= htmlspecialchars($u['hobi']); ?></td>
            <td><?= nl2br(htmlspecialchars($u['alamat'])); ?></td>
            <td>
                <a class="link" href="/lab11_php_oop/user/ubah?id=<?= $u['id']; ?>">Ubah</a> |
                <a class="link" href="/lab11_php_oop/user/hapus?id=<?= $u['id']; ?>"
                   onclick="return confirm('Hapus user ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="7">Belum ada data user.</td></tr>
    <?php endif; ?>
</table>
```

📌 7. User Tambah PHP
```
<?php
$db = new Database();
$form = new Form("", "Simpan User");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        'nama' => $_POST['nama'],
        'email' => $_POST['email'],
        'pass' => $_POST['pass'],
        'jenis_kelamin' => $_POST['jenis_kelamin'],
        'agama' => $_POST['agama'],
        'hobi' => isset($_POST['hobi']) ? implode(", ", $_POST['hobi']) : "",
        'alamat' => $_POST['alamat']
    ];

    if ($db->insert("users", $data)) {
        header("Location: /lab11_php_oop/user/index");
        exit;
    } else {
        echo "<p style='color:red;'>Gagal menyimpan user.</p>";
    }
}

$form->addField("nama", "Nama Lengkap");
$form->addField("email", "Email");
$form->addField("pass", "Password", "password");

$form->addField("jenis_kelamin", "Jenis Kelamin", "radio", [
    "L" => "Laki-laki",
    "P" => "Perempuan"
]);

$form->addField("agama", "Agama", "select", [
    "Islam" => "Islam",
    "Kristen" => "Kristen",
    "Katolik" => "Katolik",
    "Hindu" => "Hindu",
    "Budha" => "Budha"
]);

$form->addField("hobi", "Hobi", "checkbox", [
    "Membaca" => "Membaca",
    "Coding" => "Coding",
    "Traveling" => "Traveling"
]);

$form->addField("alamat", "Alamat", "textarea");
?>

<h2>Tambah User</h2>
<?php $form->displayForm(); ?>
```

## 🚀 How to Run

#### 1. Aktifkan Apache & MySQL di XAMPP

#### 2. Pindahkan project ke:

C:/xampp/htdocs/lab11_php_oop/

#### 3. Buat database:

phpMyAdmin → Create DB: lab10web

#### 4. Jalankan:

http://localhost/lab10_php_oop/index.php

## 📝 Tugas Praktikum

#### A. Implementasi modularisasi

#### B. Menjalankan semua kode OOP

#### C. Menyusun dokumentasi & screenshot

#### D. Commit ke repo GitHub Lab10Web

#### E. Submit link ke e-learning

## 📸 Screenshots

Tambahkan screenshot kamu di folder:

/screenshots/

Contoh:

![gambar]()

🎉 Conclusion

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
