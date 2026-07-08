<?php
session_start();

require_once '../config/database.php';

if (!isset($_GET['order_id'])) {
    header("Location: ../index.php");
    exit();
}

$db_obj = new database();
$koneksi = $db_obj->conn;

$order_id = $koneksi->real_escape_string($_GET['order_id']);

$metode_pembayaran = isset($_GET['method']) ? $koneksi->real_escape_string($_GET['method']) : 'Midtrans';

$query_pesanan = $koneksi->query("SELECT * FROM pesanan WHERE midtrans_order_id = '$order_id'");

if ($query_pesanan && $query_pesanan->num_rows > 0) {
    $pesanan = $query_pesanan->fetch_assoc();
    $id_pesanan = $pesanan['id_pesanan'];

    $koneksi->query("UPDATE pesanan SET 
                        status_pembayaran = 'Paid', 
                        status_pesanan = 'Diproses', 
                        metode_pembayaran = '$metode_pembayaran' 
                     WHERE id_pesanan = '$id_pesanan'");

    $query_detail = $koneksi->query("SELECT * FROM detail_pesanan WHERE id_pesanan = '$id_pesanan'");
    
    if ($query_detail && $query_detail->num_rows > 0) {
        while ($item = $query_detail->fetch_assoc()) {
            $id_produk = $item['id_produk'];
            $jumlah_beli = $item['jumlah'];

            $koneksi->query("UPDATE produk SET stok = stok - $jumlah_beli WHERE id_produk = '$id_produk'");
        }
    }

    header("Location: phpMailer.php");
    exit();

} else {
    header("Location: ../index.php");
    exit();
}
?>