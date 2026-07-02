<?php
// Pelacak error aktif agar jika ada kendala langsung muncul teksnya
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// =========================================================================
// PERUBAHAN 1: Jalur disesuaikan karena file berada di dalam folder 'proses'
// =========================================================================
require_once '../config/database.php';

$db = new database();

// 1. Validasi: Pastikan keranjang tidak kosong
if (empty($_SESSION['keranjang'])) {
    // Keluar folder untuk menuju ke index utama
    header("Location: ../index.php");
    exit();
}

// Mengambil ID User dari session login kelompokmu (Default ke id 2 jika session belum terbaca)
$id_user = $_SESSION['id_user'] ?? 2; 
$tanggal = date('Y-m-d H:i:s');

// Mulai Database Transaction agar data aman
$db->conn->begin_transaction();

try {
    // 2. Hitung total keseluruhan dan validasi stok
    $grand_total = 0;
    $item_list = [];
    
    foreach ($_SESSION['keranjang'] as $id_produk => $qty) {
        $id_produk_aman = $db->conn->real_escape_string($id_produk);
        $res = $db->conn->query("SELECT harga, stok FROM produk WHERE id_produk = '$id_produk_aman'");
        
        if ($res && $res->num_rows > 0) {
            $prod = $res->fetch_assoc();
            
            // Cek kecukupan stok barang
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

    // 3. Insert ke tabel induk `pesanan` (Disamakan dengan kolom db_toko.sql)
    $query_invoice = "INSERT INTO pesanan (id_user, tanggal_pesanan, total_harga, status_pesanan, status_pembayaran) 
                      VALUES ('$id_user', '$tanggal', '$grand_total', 'Pending', 'Pending')";
                      
    if (!$db->conn->query($query_invoice)) {
        throw new Exception("Gagal menyimpan data pesanan induk: " . $db->conn->error);
    }
    
    // Ambil ID pesanan yang barusan terbuat
    $id_pesanan_baru = $db->conn->insert_id;

    // 4. Looping untuk insert ke `detail_pesanan` dan potong stok barang
    foreach ($item_list as $item) {
        $id_prod = $item['id'];
        $qty_beli = $item['qty'];
        $harga_satuan = $item['harga'];
        $subtotal = $item['subtotal'];

        // Insert ke tabel detail_pesanan sesuai dengan urutan kolom database kalian
        $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga_satuan, subtotal) 
                         VALUES ('$id_pesanan_baru', '$id_prod', '$qty_beli', '$harga_satuan', '$subtotal')";
        
        if (!$db->conn->query($query_detail)) {
            throw new Exception("Gagal menyimpan detail pesanan: " . $db->conn->error);
        }

        // Update kurangkan stok produk di tabel produk
        $query_update_stok = "UPDATE produk SET stok = stok - $qty_beli WHERE id_produk = '$id_prod'";
        if (!$db->conn->query($query_update_stok)) {
            throw new Exception("Gagal memperbarui stok produk: " . $db->conn->error);
        }
    }

    // Jika semua proses query berjalan lancar, simpan permanen ke database
    $db->conn->commit();

    // 5. Kosongkan isi keranjang belanja session
    unset($_SESSION['keranjang']);

    // =========================================================================
    // PERUBAHAN 2: Ditambahkan '../' pada window.location.href agar kembali ke root luar
    // =========================================================================
    echo "<script>
            alert('Proses Checkout Berhasil! Pesanan Anda telah tersimpan di database.');
            window.location.href = '../index.php';
          </script>";
    exit();

} catch (Exception $e) {
    // Jika ada satu saja yang gagal, batalkan seluruh manipulasi data di atas
    $db->conn->rollback();
    
    // =========================================================================
    // PERUBAHAN 3: Ditambahkan '../' agar dialihkan keluar folder menuju keranjang.php
    // =========================================================================
    echo "<script>
            alert('Gagal melakukan checkout: " . $e->getMessage() . "');
            window.location.href = '../keranjang.php';
          </script>";
    exit();
}
?>