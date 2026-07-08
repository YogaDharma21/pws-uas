<?php
    require_once '../../classes/produk.php';
    $produk = new produk();

    if (isset($_GET['id'])) {
        $id = $_GET['id']; 
        
        if ($produk->delete($id)) {
            echo "<script>alert('Berhasil hapus Data');window.location.href = '../produkPage.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal hapus Data');window.location.href = '../produkPage.php';</script>";
            exit;
        }
    } else {
        header('Location: ../produkPage.php');
        exit;
    }
?>