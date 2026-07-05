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
            $qry = "SELECT $this->table.*, roles.nama_role FROM $this->table
            INNER JOIN roles ON $this->table.id_role = roles.id_role 
            ORDER BY $this->table.id_user ASC";
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

         public function update($id_user, $id_role, $nama, $email, $no_hp, $alamat){
            $qry = "UPDATE $this->table SET id_role = ?, nama = ?, email = ?, no_hp = ?, alamat = ? WHERE id_user = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("issssi", $id_role, $nama, $email, $no_hp, $alamat, $id_user);
            return $stmt->execute();
        }
        
        public function delete($id_user){
            $qry = "DELETE FROM $this->table WHERE id_user = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("i", $id_user);
            return $stmt->execute();
        }
    }
?>