<?php
class produk {
    private $db;

    public function __construct($db_koneksi){
        $this->db = $db_koneksi;
    }

    public function ambilProduk($id_kategori = null, $keyword = null){
        $query = "SELECT * FROM produk WHERE 1=1";
        
        if ($id_kategori !== null) {
            $id_kategori = $this->db->conn->real_escape_string($id_kategori);
            $query .= " AND id_kategori = '$id_kategori'";
        }
        
        if ($keyword !== null && trim($keyword) !== '') {
            $keyword = $this->db->conn->real_escape_string($keyword);
            $query .= " AND (nama_produk LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%')";
        }
        
        $query .= " ORDER BY id_produk DESC";
        
        $eksekusi = $this->db->conn->query($query);
        return $eksekusi;
    }
}
?>