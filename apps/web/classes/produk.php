<?php
class produk {
    private $db;

    // Saat objek produk dibuat, kita lempar koneksi database ke dalamnya
    public function __construct($db_koneksi){
        $this->db = $db_koneksi;
    }

    // Fungsi ambilProduk yang mendukung filter kategori dan keyword pencarian sekaligus
    public function ambilProduk($id_kategori = null, $keyword = null){
        // Query dasar menggunakan WHERE 1=1 agar penggabungan kondisi AND dinamis dan aman
        $query = "SELECT * FROM produk WHERE 1=1";
        
        // Jika ada filter kategori yang dikirim dari URL
        if ($id_kategori !== null) {
            $id_kategori = $this->db->conn->real_escape_string($id_kategori);
            $query .= " AND id_kategori = '$id_kategori'";
        }
        
        // Jika ada kata kunci pencarian yang dimasukkan user
        if ($keyword !== null && trim($keyword) !== '') {
            $keyword = $this->db->conn->real_escape_string($keyword);
            // Mencari yang nama produk atau deskripsinya mirip dengan keyword
            $query .= " AND (nama_produk LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%')";
        }
        
        // Urutkan produk mulai dari yang terbaru berdasarkan id_produk
        $query .= " ORDER BY id_produk DESC";
        
        $eksekusi = $this->db->conn->query($query);
        return $eksekusi;
    }
}
?>