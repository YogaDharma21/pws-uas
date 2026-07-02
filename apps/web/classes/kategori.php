<?php
    require_once __DIR__ . '/../config/database.php';
    class kategori extends database{
        private $table = 'kategori';

        public function create($nama_kategori){
            $qry = "INSERT INTO $this->table (nama_kategori) VALUES (?)";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("s", $nama_kategori);
            return $stmt->execute();
        }

        public function getAll () {
            $qry = "SELECT * FROM $this->table ";
            return $this->conn->query($qry);
        }

        public function getById($id_kategori){
            $qry = "SELECT * FROM $this->table WHERE id_kategori = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("i", $id_kategori);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
    
        }

        public function update ($id_kategori, $nama_kategori) {
            $qry = "UPDATE $this->table SET nama_kategori = ? WHERE id_kategori = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("si", $nama_kategori, $id_kategori);
            return $stmt->execute();
        }

        public function delete($id_kategori){
            $qry = "DELETE FROM $this->table WHERE id_kategori = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("i", $id_kategori);
            return $stmt->execute();
        }
    }

?>