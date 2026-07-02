<?php
session_start();

// =========================================================================
// PERUBAHAN 1: Jalur disesuaikan karena file berada di dalam folder 'proses'
// =========================================================================
require_once '../config/database.php';

// Cek apakah ada parameter ID produk yang dikirim
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Jika session keranjang belum ada, buat array baru
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Jika produk sudah ada di keranjang, tambahkan jumlahnya (+1)
    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk] += 1;
    } else {
        // Jika belum ada, masukkan dengan jumlah awal = 1
        $_SESSION['keranjang'][$id_produk] = 1;
    }

    // =========================================================================
    // PERUBAHAN 2: Ditambahkan '../' agar dialihkan keluar folder menuju keranjang.php
    // =========================================================================
    header("Location: ../keranjang.php");
    exit();
} else {
    // Ditambahkan '../' agar dialihkan keluar folder menuju index.php
    header("Location: ../index.php");
    exit();
}
?>