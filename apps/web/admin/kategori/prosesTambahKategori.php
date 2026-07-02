<?php
    require_once '../../classes/kategori.php';
    $kategori = new kategori();

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nama_kategori = $_POST['nama'];
        
        if ($kategori->create($nama_kategori)) {
            echo "<script>alert('Kategori berhasil ditambahkan'); window.location.href='../kategoriPage.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan kategori'); window.location.href='tambahKategori.php';</script>";
        }
    }


?>