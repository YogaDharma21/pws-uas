<?php
session_start();
require_once 'config/database.php'; // Tetap aman karena file database tidak pindah

$db = new database();

// 1. Logika untuk Update Jumlah (Quantity) lewat tombol "Perbarui Keranjang"
if (isset($_POST['update_keranjang'])) {
    if (isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $id_prod => $jumlah) {
            $jumlah = (int)$jumlah;
            if ($jumlah <= 0) {
                unset($_SESSION['keranjang'][$id_prod]); 
            } else {
                $_SESSION['keranjang'][$id_prod] = $jumlah; 
            }
        }
    }
    header("Location: keranjang.php");
    exit();
}

// 2. Logika untuk Hapus item tertentu dari keranjang via tombol Trash/Hapus
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id_hapus = $_GET['id'];
    if (isset($_SESSION['keranjang'][$id_hapus])) {
        unset($_SESSION['keranjang'][$id_hapus]);
    }
    header("Location: keranjang.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - TECHNO ZONE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/filled/boxicons-filled.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary mb-4">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold d-flex align-items-center" href="index.php">
                <i class="bxf bx-circuit-board me-2" style="font-size: 1.6rem;"></i>TECHNO ZONE
            </a>
            <div class="navbar-text ms-auto text-white">
                <small>Halo, <strong><?php echo $_SESSION['nama'] ?? 'Pelanggan'; ?></strong></small>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="fw-bold mb-4"><i class="fa-solid fa-cart-shopping text-primary me-2"></i>Keranjang Belanja Anda</h2>
        
        <div class="mb-4">
            <a href="index.php" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali Pilih Produk</a>
        </div>

        <?php if (!empty($_SESSION['keranjang'])): ?>
            <form action="keranjang.php" method="POST">
                <div class="card border-0 shadow-sm p-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th style="width: 130px;" class="text-center">Jumlah Beli</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $grand_total = 0;
                                foreach ($_SESSION['keranjang'] as $id_produk => $qty): 
                                    $id_produk_aman = $db->conn->real_escape_string($id_produk);
                                    $query = $db->conn->query("SELECT * FROM produk WHERE id_produk = '$id_produk_aman'");
                                    
                                    if ($query && $query->num_rows > 0) {
                                        $row = $query->fetch_assoc();
                                        $total_harga_produk = $row['harga'] * $qty;
                                        $grand_total += $total_harga_produk;
                                ?>
                                <tr>
                                    <td>
                                        <h6 class="fw-bold text-dark mb-0"><?php echo htmlspecialchars($row['nama_produk']); ?></h6>
                                        <small class="text-muted">Stok Tersedia: <?php echo $row['stok']; ?></small>
                                    </td>
                                    <td class="text-end">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <input type="number" name="qty[<?php echo $id_produk; ?>]" class="form-control form-control-sm text-center" value="<?php echo $qty; ?>" min="1" max="<?php echo $row['stok']; ?>">
                                    </td>
                                    <td class="text-end fw-bold text-primary">Rp <?php echo number_format($total_harga_produk, 0, ',', '.'); ?></td>
                                    <td>
                                        <a href="keranjang.php?action=hapus&id=<?php echo $id_produk; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?');">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                endforeach; 
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 border-top pt-4">
                        <button type="submit" name="update_keranjang" class="btn btn-primary mb-3 mb-md-0">
                            <i class="fa-solid fa-rotate me-1"></i> Perbarui Kuantitas Belanja
                        </button>
                        
                        <div class="text-end">
                            <h4 class="mb-1 text-muted small text-uppercase fw-bold">Total Pembayaran:</h4>
                            <h2 class="text-danger fw-bold mb-3">Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></h2>
                            
                            <a href="proses/proses_checkout_midtrans.php" class="btn btn-success btn-lg px-5 fw-bold shadow-sm">
                                <i class="fa-solid fa-money-check-dollar me-2"></i> Selesaikan Pesanan (Checkout)
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="card border-0 shadow-sm text-center p-5">
                <div class="my-3">
                    <i class="fa-solid fa-basket-shopping fa-4x text-muted opacity-50 mb-3"></i>
                    <h4 class="fw-bold text-secondary">Keranjang Kosong</h4>
                    <p class="text-muted">Anda belum menambahkan produk apa pun ke dalam keranjang belanja.</p>
                    <a href="index.php" class="btn btn-primary mt-2"><i class="fa-solid fa-bag-shopping me-2"></i>Mulai Belanja Sekarang</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>