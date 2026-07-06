<?php
    require_once __DIR__ . '/../config/database.php';
    class detailPsn extends database{
        private $table = 'detail_pesanan';
        
        public function readDetail($id_pesanan){
            $qry = "SELECT $this->table.*, produk.nama_produk
            FROM $this->table 
            INNER JOIN produk ON $this->table.id_produk = produk.id_produk
            WHERE $this->table.id_pesanan = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("i", $id_pesanan);
            $stmt->execute();
            return $stmt->get_result();
        }
    
    }
?>