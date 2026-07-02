<?php
    require_once '../../classes/kategori.php';
    $kategori = new kategori();

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_kategori = $_POST['id'];
        $nama_kategori = $_POST['nama'];
        
        if ($kategori->update($id_kategori, $nama_kategori)) {
            echo "<script>alert('Kategori berhasil diperbarui'); window.location.href='../kategoriPage.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui kategori'); window.location.href='updateKategori.php?id=" . $id_kategori . "';</script>";
        }
    }


?>