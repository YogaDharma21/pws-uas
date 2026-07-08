<?php
require_once '../../classes/produk.php'; 
$produk = new produk();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kategori = trim($_POST['id_kategori']);
    $nama_produk = trim($_POST['nama_produk']);
    $deskripsi   = trim($_POST['deskripsi']);
    $harga       = trim($_POST['harga']);
    $stok        = trim($_POST['stok']);
    $file_gambar = $produk->upload_file(); 

    if ($produk->create($id_kategori, $nama_produk, $deskripsi, $harga, $stok, $file_gambar)) {
        echo "<script>
                alert('Produk dan gambar berhasil ditambahkan!'); 
                window.location.href='../produkPage.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan produk!'); 
                window.location.href='tambahProduk.php';
              </script>";
    }
}
?>