<?php
session_start();

require_once 'config/database.php';
require_once 'classes/produk_user.php'; 

$db = new database();
$produkObj = new produk_user($db); 

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : null;

$data_produk = $produkObj->ambilProduk($id_kategori, $keyword); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHNO ZONE - Toko Elektronik & Gadget</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/filled/boxicons-filled.min.css" rel="stylesheet">
    
    <style>
        .hero-section {
            background: linear-gradient(rgba(15, 23, 42, 0.9), rgba(30, 41, 59, 0.95)), url('https://images.unsplash.com/photo-1531297484001-80022131f5a1?q=80&w=1200') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        .search-bar {
            max-width: 600px;
            margin: 0 auto;
        }
        .category-link {
            text-decoration: none;
            color: #495057;
            display: block;
            padding: 8px 12px;
            border-radius: 4px;
        }
        .category-link:hover, .category-link.active {
            background-color: #f1f5f9;
            color: #0d6efd;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold d-flex align-items-center" href="index.php">
                <i class="bxf bx-circuit-board me-2" style="font-size: 1.6rem;"></i>TECHNO ZONE
            </a>
            <div class="navbar-text ms-auto text-white">
                <small class="me-3">Halo, <strong><?php echo $_SESSION['nama'] ?? 'Pelanggan'; ?></strong></small>
                <a href="logout.php" class="btn btn-outline-danger btn-sm"><i class="bx bx-log-out me-1"></i>Logout</a>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <span class="badge bg-primary mb-2">Pusat Gadget & Laptop Terpercaya</span>
            <h1 class="fw-bold mb-3">Temukan Gadget Impian Anda <span class="text-primary">Disini</span></h1>
            <p class="text-secondary mb-4">Menyediakan laptop performa tinggi, smartphone flagship, dan aksesoris elektronik bergaransi resmi.</p>
            
            <div class="search-bar">
                <form action="index.php" method="GET">
                    <?php if (!empty($id_kategori)): ?>
                        <input type="hidden" name="id_kategori" value="<?php echo htmlspecialchars($id_kategori); ?>">
                    <?php endif; ?>
                    
                    <div class="input-group input-group-lg">
                        <input type="text" name="keyword" class="form-control border-0 shadow-sm" placeholder="Cari laptop gaming, smartphone, tablet, atau brand..." value="<?php echo htmlspecialchars($keyword); ?>">
                        <button class="btn btn-primary shadow-sm" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm p-3">
                    <h5 class="fw-bold mb-3 text-uppercase small text-muted">Kategori Produk</h5>
                    <div class="d-grid gap-1">
                        <a href="index.php<?php echo !empty($keyword) ? '?keyword='.urlencode($keyword) : ''; ?>" class="category-link <?php echo empty($id_kategori) ? 'active' : ''; ?>">
                            Semua Kategori
                        </a>
                        <a href="index.php?id_kategori=1<?php echo !empty($keyword) ? '&keyword='.urlencode($keyword) : ''; ?>" class="category-link <?php echo ($id_kategori == 1) ? 'active' : ''; ?>">
                            <i class="bx bx-laptop me-2"></i> Laptop & Notebook
                        </a>
                        <a href="index.php?id_kategori=2<?php echo !empty($keyword) ? '&keyword='.urlencode($keyword) : ''; ?>" class="category-link <?php echo ($id_kategori == 2) ? 'active' : ''; ?>">
                            <i class="bx bx-mobile-alt me-2"></i> Smartphone & HP
                        </a>
                        <a href="index.php?id_kategori=3<?php echo !empty($keyword) ? '&keyword='.urlencode($keyword) : ''; ?>" class="category-link <?php echo ($id_kategori == 3) ? 'active' : ''; ?>">
                            <i class="bx bx-tablet me-2"></i> Tablet & iPad
                        </a>
                        <a href="index.php?id_kategori=4<?php echo !empty($keyword) ? '&keyword='.urlencode($keyword) : ''; ?>" class="category-link <?php echo ($id_kategori == 4) ? 'active' : ''; ?>">
                            <i class="bx bx-headphone me-2"></i> Aksesoris Audio
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <?php if (!empty($keyword)): ?>
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        Menampilkan hasil pencarian untuk: <strong>"<?php echo htmlspecialchars($keyword); ?>"</strong>
                        <a href="index.php<?php echo !empty($id_kategori) ? '?id_kategori='.$id_kategori : ''; ?>" class="float-end text-decoration-none text-danger fw-bold">Hapus Pencarian</a>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <?php 
                    if ($data_produk && $data_produk->num_rows > 0) {
                        while ($row = $data_produk->fetch_assoc()) {
                    ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    
                                    <?php 
                                    $file_gambar = "assets/images/" . $row['gambar'];
                                    if (!empty($row['gambar']) && file_exists($file_gambar)) {
                                        $sumber_gambar = $file_gambar;
                                    } else {
                                        $sumber_gambar = "https://placehold.co/300x200?text=Techno+Zone";
                                    }
                                    ?>
                                    <img src="<?php echo $sumber_gambar; ?>" class="card-img-top" style="height: 180px; object-fit: contain; padding: 15px;" alt="Produk Elektronik">
                                    
                                    <div class="card-body d-flex flex-column">
                                        <small class="text-primary fw-bold mb-1 text-uppercase text-xs" style="font-size: 11px;">
                                            <?php 
                                            
                                            if ($row['id_kategori'] == 1) echo 'LAPTOP';
                                            elseif ($row['id_kategori'] == 2) echo 'SMARTPHONE';
                                            elseif ($row['id_kategori'] == 3) echo 'TABLET';
                                            elseif ($row['id_kategori'] == 4) echo 'AUDIO';
                                            else echo 'GADGET';
                                            ?>
                                        </small>
                                        <h6 class="card-title fw-bold text-dark mb-2"><?php echo $row['nama_produk']; ?></h6>
                                        <p class="card-text text-muted small text-truncate mb-3"><?php echo $row['deskripsi']; ?></p>
                                        
                                        <div class="mt-auto">
                                            <h5 class="text-dark fw-bold mb-2">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></h5>
                                            <small class="text-secondary d-block mb-3">Stok tersedia: <?php echo $row['stok']; ?></small>
                                            
                                            <a href="proses/beli.php?id=<?php echo $row['id_produk']; ?>" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="bx bx-cart-add me-1"></i> Tambah Ke Keranjang
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php 
                        } 
                    } else { 
                    ?>
                        <div class="col-12">
                            <div class="alert alert-light text-center border p-5 shadow-sm">
                                <i class="bxf bx-circuit-board fa-3x text-muted mb-3" style="font-size: 3rem;"></i>
                                <p class="text-muted mb-0">Belum ada produk atau tidak ada hasil yang cocok dengan pencarian Anda.</p>
                            </div>
                        </div>
                    <?php 
                    } 
                    ?>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>