<?php
require_once '../../classes/produk.php'; 
$produk = new produk();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kategori = $_POST['id_kategori'];
    $nama_produk = $_POST['nama_produk'];
    $deskripsi   = $_POST['deskripsi'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
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