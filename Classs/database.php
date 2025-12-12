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
