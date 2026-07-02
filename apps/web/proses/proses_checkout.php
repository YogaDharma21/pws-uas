<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once '../config/database.php';

$db = new database();

if (empty($_SESSION['keranjang'])) {
    header("Location: ../index.php");
    exit();
}

$id_user = $_SESSION['id_user'] ?? 2; 
$tanggal = date('Y-m-d H:i:s');

$db->conn->begin_transaction();

try {
    $grand_total = 0;
    $item_list = [];
    
    foreach ($_SESSION['keranjang'] as $id_produk => $qty) {
        $id_produk_aman = $db->conn->real_escape_string($id_produk);
        $res = $db->conn->query("SELECT harga, stok FROM produk WHERE id_produk = '$id_produk_aman'");
        
        if ($res && $res->num_rows > 0) {
            $prod = $res->fetch_assoc();
            
            if ($prod['stok'] < $qty) {
                throw new Exception("Stok tidak mencukupi untuk produk ID: " . $id_produk);
            }
            
            $subtotal_produk = $prod['harga'] * $qty;
            $grand_total += $subtotal_produk;
            
            $item_list[] = [
                'id' => $id_produk_aman,
                'qty' => $qty,
                'harga' => $prod['harga'],
                'subtotal' => $subtotal_produk
            ];
        }
    }

    $query_invoice = "INSERT INTO pesanan (id_user, tanggal_pesanan, total_harga, status_pesanan, status_pembayaran) 
                      VALUES ('$id_user', '$tanggal', '$grand_total', 'Pending', 'Pending')";
                      
    if (!$db->conn->query($query_invoice)) {
        throw new Exception("Gagal menyimpan data pesanan induk: " . $db->conn->error);
    }
    
    $id_pesanan_baru = $db->conn->insert_id;

    foreach ($item_list as $item) {
        $id_prod = $item['id'];
        $qty_beli = $item['qty'];
        $harga_satuan = $item['harga'];
        $subtotal = $item['subtotal'];

        $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga_satuan, subtotal) 
                         VALUES ('$id_pesanan_baru', '$id_prod', '$qty_beli', '$harga_satuan', '$subtotal')";
        
        if (!$db->conn->query($query_detail)) {
            throw new Exception("Gagal menyimpan detail pesanan: " . $db->conn->error);
        }

        $query_update_stok = "UPDATE produk SET stok = stok - $qty_beli WHERE id_produk = '$id_prod'";
        if (!$db->conn->query($query_update_stok)) {
            throw new Exception("Gagal memperbarui stok produk: " . $db->conn->error);
        }
    }

    $db->conn->commit();

    unset($_SESSION['keranjang']);

    echo "<script>
            alert('Proses Checkout Berhasil! Pesanan Anda telah tersimpan di database.');
            window.location.href = '../index.php';
          </script>";
    exit();

} catch (Exception $e) {
    $db->conn->rollback();
    
    echo "<script>
            alert('Gagal melakukan checkout: " . $e->getMessage() . "');
            window.location.href = '../keranjang.php';
          </script>";
    exit();
}
?>