<?php
    require_once __DIR__ . '/../config/database.php';
    class produk extends database{
        private $table = 'produk';

        public function create($id_kategori, $nama_produk, $deskripsi, $harga, $stok, $gambar){
            $qry = "INSERT INTO $this->table (id_kategori, nama_produk, deskripsi, harga, stok, gambar) VALUES (?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("issdis", $id_kategori, $nama_produk, $deskripsi, $harga, $stok, $gambar);
            return $stmt->execute();
        }
    
        public function read() {
            $qry = "SELECT $this->table.*, kategori.nama_kategori FROM $this->table
            INNER JOIN kategori ON $this->table.id_kategori = kategori.id_kategori 
            ORDER BY $this->table.id_produk ASC";
            return $this->conn->query($qry);
        }

        public function readById($id_produk) {
            $qry = "SELECT * FROM $this->table WHERE id_produk = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("i", $id_produk);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function update ($id_produk, $id_kategori, $nama_produk, $deskripsi, $harga, $stok, $gambar) {
            $qry = "UPDATE $this->table SET id_kategori = ?, nama_produk = ?, deskripsi = ?, harga = ?, stok = ?, gambar = ? WHERE id_produk = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("issdisi", $id_kategori, $nama_produk, $deskripsi, $harga, $stok, $gambar, $id_produk);
            return $stmt->execute();
        }

        public function delete($id_produk){
            $qry = "DELETE FROM $this->table WHERE id_produk = ?";
            $stmt = $this->conn->prepare($qry);
            $stmt->bind_param("i", $id_produk);
            return $stmt->execute();
        }

        public function cekStatusStok($stok) {
            if ($stok == 0) {
                return "<p> Stok Habis</p>";
            } elseif ($stok < 5) {
                return "<p> Stok Menipis</p>";
            } else {
                return "<p>Aman</p>";
            }
        }

        function upload_file(){
            $namaFile = $_FILES['gambar']['name'];
            $ukuranFile = $_FILES['gambar']['size'];
            $error = $_FILES['gambar']['error'];
            $tmpName = $_FILES['gambar']['tmp_name'];

            $ekstensiFileValid = ['jpg', 'jpeg', 'png'];
            $ekstensiFile     = explode('.', $namaFile);
            $ekstensiFile      = strtolower(end($ekstensiFile));

            if (!in_array($ekstensiFile, $ekstensiFileValid)){
                echo "<script>
                        alert('Format file tidak valid!'); 
                        window.location.href='tambahProduk.php';
                      </script>";
                      return false;
            }

            if ($ukuranFile > 2000000){
                echo "<script>
                        alert('Ukuran file terlalu besar!'); 
                        window.location.href='tambahProduk.php';
                      </script>";
                      return false;
            }

            $namaFileBaru = uniqid();
            $namaFileBaru .= '.';
            $namaFileBaru .= $ekstensiFile;

            move_uploaded_file($tmpName, '../../assets/img/' . $namaFileBaru);
            return $namaFileBaru;
        }
    }
?>