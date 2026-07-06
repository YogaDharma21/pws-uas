<?php
    require_once '../../classes/pesanan.php';
    $pesanan = new Pesanan();

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_pesanan = $_POST['id_pesanan'];
        $status_pesanan = $_POST['status_pesanan'];
        $status_pembayaran = $_POST['status_pembayaran'];
        
        if ($pesanan->updateStatus($id_pesanan, $status_pesanan, $status_pembayaran)) {
            echo "<script>alert('Pesanan berhasil diperbarui'); window.location.href='../pesananPage.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui pesanan'); window.location.href='updatePesanan.php?id=" . $id_pesanan . "';</script>";
        }
    }
?>
