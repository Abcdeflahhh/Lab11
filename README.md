# 🌑 **Project Title — LAB10_PHP_OOP**
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
📁 lab10_php_oop/
│── mobil.php
│── form.php
│── form_input.php
│── database.php
│── config.php
│── README.md
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

🧩 Main Codes
📌 1. mobil.php (OOP Basic)
```
class Mobil
{
    private $warna;
    private $merk;
    private $harga;

    public function __construct()
    {
        $this->warna = "Biru";
        $this->merk = "BMW";
        $this->harga = "10000000";
    }

    public function gantiWarna($warnaBaru)
    {
        $this->warna = $warnaBaru;
    }

    public function tampilWarna()
    {
        echo "Warna mobilnya : " . $this->warna;
    }
}
```

📌 2. form.php (Form Builder Class)
```
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

    public function displayForm()
    {
        echo "<form action='".$this->action."' method='POST'>";
        echo '<table width="100%" border="0">';

        for ($j = 0; $j < count($this->fields); $j++) {
            echo "<tr><td>".$this->fields[$j]['label']."</td>";
            echo "<td><input type='text' name='".$this->fields[$j]['name']."'></td></tr>";
        }

        echo "<tr><td colspan='2'>";
        echo "<input type='submit' value='".$this->submit."'>";
        echo "</td></tr>";
        echo "</table>";
    }

    public function addField($name, $label)
    {
        $this->fields[$this->jumField]['name'] = $name;
        $this->fields[$this->jumField]['label'] = $label;
        $this->jumField++;
    }
}
```

📌 3. form_input.php
```
include "form.php";

echo "<html><head><title>Mahasiswa</title></head><body>";

$form = new Form("", "Input Form");
$form->addField("txtnim", "Nim");
$form->addField("txtnama", "Nama");
$form->addField("txtalamat", "Alamat");

echo "<h3>Silahkan isi form berikut ini :</h3>";
$form->displayForm();

echo "</body></html>";
```

📌 4. database.php (Database Connection Class)
```
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
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    private function getConfig() {
        include_once("config.php");
        $this->host = $config['host'];
        $this->user = $config['username'];
        $this->password = $config['password'];
        $this->db_name = $config['db_name'];
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function get($table, $where=null) {
        if ($where) $where = " WHERE ".$where;
        return $this->conn->query("SELECT * FROM ".$table.$where)->fetch_assoc();
    }

    public function insert($table, $data) {
        foreach ($data as $key => $val) {
            $col[] = $key;
            $valArr[] = "'{$val}'";
        }
        $columns = implode(",", $col);
        $values  = implode(",", $valArr);

        return $this->conn->query("INSERT INTO $table ($columns) VALUES ($values)");
    }
}
```

## 🚀 How to Run

#### 1. Aktifkan Apache & MySQL di XAMPP

#### 2. Pindahkan project ke:

C:/xampp/htdocs/lab10_php_oop/

#### 3. Buat database:

phpMyAdmin → Create DB: lab10web

#### 4. Jalankan:

http://localhost/lab10_php_oop/form_input.php

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

![gambar](https://github.com/Abcdeflahhh/lab10_php_oop/blob/23ed09d21708e7dc27a940c98553f046e5bb7cfb/Image/2025-12-03%2019_58_39-Input%20Data%20Mahasiswa%20and%201%20more%20page%20-%20Personal%20-%20Microsoft%E2%80%8B%20Edge.png)

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
