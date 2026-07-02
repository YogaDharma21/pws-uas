<?php
    require_once __DIR__ . '/../config/database.php';
    class users extends database{
        private $table = 'users';

        public function create($id_role, $nama, $email, $password, $no_hp, $alamat){
            $qry = "INSERT INTO $this->table (id_role, nama, email, password, no_hp, alamat) VALUES (?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("isssss", $id_role, $nama, $email, $password, $no_hp, $alamat);
            return $stmt->execute();
        }
        
        public function read() {
            $qry = "SELECT * FROM $this->table ";
            return $this->conn->query($qry);
            
        }
     
        public function readById($id_user){
            $qry = "SELECT * FROM $this->table WHERE id_user = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("i", $id_user);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function readByEmail($email) {
            $qry = "SELECT * FROM $this->table WHERE email = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc(); 
        }
        
    }
?>