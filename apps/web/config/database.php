<?php
    class database{
        // Properti public agar koneksinya bisa langsung dipanggil di file lain dengan mudah
        public $conn; 
        
        public function __construct(){
            $this->connect();
        }
        protected function connect(){
            $host = "localhost";
            $user = "root";
            $pass = "";
            $db = "db_toko";

            $this->conn = new mysqli($host, $user, $pass, $db);
            if($this->conn->connect_error){
                die("Koneksi Error" . $this->conn->connect_error);
            }
        }

        // Fungsi ambilProduk yang mendukung filter kategori dan keyword pencarian sekaligus
        public function ambilProduk($id_kategori = null, $keyword = null){
            // Query dasar menggunakan WHERE 1=1 agar penggabungan kondisi AND di bawahnya menjadi dinamis dan aman
            $query = "SELECT * FROM produk WHERE 1=1";
            
            // Jika ada filter kategori yang dikirim dari URL
            if ($id_kategori !== null) {
                $id_kategori = $this->conn->real_escape_string($id_kategori);
                $query .= " AND id_kategori = '$id_kategori'";
            }
            
            // Jika ada kata kunci pencarian yang dimasukkan user
            if ($keyword !== null && trim($keyword) !== '') {
                $keyword = $this->conn->real_escape_string($keyword);
                // Mencari yang nama produk atau deskripsinya mirip dengan keyword
                $query .= " AND (nama_produk LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%')";
            }
            
            // Urutkan produk mulai dari yang terbaru berdasarkan id_produk
            $query .= " ORDER BY id_produk DESC";
            
            $eksekusi = $this->conn->query($query);
            return $eksekusi;
        }
    }
?>