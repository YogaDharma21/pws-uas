<?php
session_start();

require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk] += 1;
    } else {
        $_SESSION['keranjang'][$id_produk] = 1;
    }

    header("Location: ../keranjang.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>