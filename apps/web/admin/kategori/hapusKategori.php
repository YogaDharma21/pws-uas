<?php
    require_once '../../classes/kategori.php';
    $kategori = new kategori();
        $id = $_GET['id_kategori'];
        
        if($kategori->delete($id)){
            echo "<script>alert('Berhasil hapus Data');window.location='kategoriPage.php'</script>";
        }else{
            echo "<script>alert('Gagal hapus Data');window.location='kategoriPage.php'</script>";
        }
?>
