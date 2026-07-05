<?php
    require_once __DIR__ . '/../config/database.php';
    class role extends database{
        private $table = 'roles';

        public function getAll () {
            $qry = "SELECT * FROM $this->table ";
            return $this->conn->query($qry);
        }
    }