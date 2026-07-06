<?php
    require_once __DIR__ . '/../config/database.php';
    class Pesanan extends database{
        private $table = 'pesanan';

        public function updateStatus($id_pesanan, $status_pesanan, $status_pembayaran) {
            $qry = "UPDATE $this->table SET status_pesanan = ?, status_pembayaran = ? WHERE id_pesanan = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("ssi", $status_pesanan, $status_pembayaran, $id_pesanan);
            return $stmt->execute();
        }

        public function read(){
            $qry = "SELECT $this->table.*, users.nama FROM $this->table
            INNER JOIN users ON $this->table.id_user = users.id_user
            ORDER BY $this->table.id_pesanan ASC";
            return $this->conn->query($qry); 
        }

        public function readById($id_pesanan) {
            $qry = "SELECT * FROM $this->table
            INNER JOIN users ON $this->table.id_user = users.id_user
            WHERE $this->table.id_pesanan = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("i", $id_pesanan);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
    }
?>