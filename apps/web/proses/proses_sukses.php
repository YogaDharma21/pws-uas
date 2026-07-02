<?php
session_start();

// =========================================================================
// PERUBAHAN 1: Jalur disesuaikan karena file berada di dalam folder 'proses'
// =========================================================================
require_once '../config/database.php';

if (!isset($_GET['order_id'])) {
    // Keluar folder untuk menuju ke index utama
    header("Location: ../index.php");
    exit();
}

$db_obj = new database();
$koneksi = $db_obj->conn;

$order_id = $koneksi->real_escape_string($_GET['order_id']);

// Tangkap parameter 'method' dari URL (dikirim oleh JavaScript di checkout)
// Jika tidak ada parameter method, diberi nilai default 'Midtrans'
$metode_pembayaran = isset($_GET['method']) ? $koneksi->real_escape_string($_GET['method']) : 'Midtrans';

// 1. Cari pesanan berdasarkan midtrans_order_id
$query_pesanan = $koneksi->query("SELECT * FROM pesanan WHERE midtrans_order_id = '$order_id'");

if ($query_pesanan && $query_pesanan->num_rows > 0) {
    $pesanan = $query_pesanan->fetch_assoc();
    $id_pesanan = $pesanan['id_pesanan'];

    // 2. UPDATE: Status Pembayaran ('Paid'), Status Pesanan ('Diproses'), dan Kolom Metode Pembayaran
    $koneksi->query("UPDATE pesanan SET 
                        status_pembayaran = 'Paid', 
                        status_pesanan = 'Diproses', 
                        metode_pembayaran = '$metode_pembayaran' 
                     WHERE id_pesanan = '$id_pesanan'");

    // 3. Eksekusi pemotongan stok produk
    $query_detail = $koneksi->query("SELECT * FROM detail_pesanan WHERE id_pesanan = '$id_pesanan'");
    
    if ($query_detail && $query_detail->num_rows > 0) {
        while ($item = $query_detail->fetch_assoc()) {
            $id_produk = $item['id_produk'];
            $jumlah_beli = $item['jumlah'];

            // Mengurangi jumlah stok di tabel produk
            $koneksi->query("UPDATE produk SET stok = stok - $jumlah_beli WHERE id_produk = '$id_produk'");
        }
    }

    // =========================================================================
    // PERUBAHAN 2: Ditambahkan '../' pada window.location.href agar kembali ke root luar
    // =========================================================================
    echo "<script>
            alert('Pembayaran Berhasil! Metode pembayaran tercatat dan stok telah diperbarui.');
            window.location.href = '../index.php';
          </script>";
    exit();

} else {
    // Keluar folder untuk menuju ke index utama jika data tidak ditemukan
    header("Location: ../index.php");
    exit();
}
?>