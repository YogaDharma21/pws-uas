<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        echo 
        "<script>
            alert('Anda harus login terlebih dahulu!'); 
            window.location.href = '../login.php';
        </script>";
        exit;   
    }

    if ($_SESSION['id_role'] != 1) {
    echo 
    "<script> 
        alert('Akses Ditolak! Halaman ini hanya untuk Admin.'); 
        window.location.href = '../index.php';
    </script>";
    exit; 
}
    require_once '../classes/produk.php';
    require_once '../classes/kategori.php';
    require_once '../classes/users.php';
    require_once '../classes/pesanan.php';

    $produk = new Produk();
    $kategori = new Kategori();
    $user = new Users();
    $pesanan = new Pesanan();

    $totalProduk = $produk->totalProduk();
    $totalKategori = $kategori->totalKategori();
    $totalUsers = $user->totalUsers();
    $totalPesanan = $pesanan->totalPesanan();

    $page = 'dashboard';

    include 'templates/header.php';
    include 'templates/sidebar.php';
    include 'templates/navbar.php';
?>

<div class="header-action">
    <div class="title-area">
        <h1>Dashboard</h1>
        <p></p>
    </div>
</div>

<div class="dashboard-card">

    <div class="card">
        <h3>Total Produk</h3>
        <h1><?php echo $totalProduk['total']; ?></h1>
    </div>

    <div class="card">
        <h3>Total Kategori</h3>
        <h1><?php echo $totalKategori['total']; ?></h1>
    </div>

    <div class="card">
        <h3>Total Users</h3>
        <h1><?php echo $totalUsers['total']; ?></h1>
    </div>

    <div class="card">
        <h3>Total Pesanan</h3>
        <h1><?php echo $totalPesanan['total']; ?></h1>
    </div>
</div>
    
<table class="table">
    <tr>
        <th>ID </th>
        <th>Tanggal</th>
        <th>Nama Customer</th>
        <th>Total</th>
    </tr>
    <?php
        require_once '../classes/pesanan.php';
        $pesanan = new Pesanan();
        $dataPesanan = $pesanan->read();
        if ($dataPesanan && $dataPesanan->num_rows > 0) {
            while ($row = $dataPesanan->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['id_pesanan']; ?></td>
                    <td><?php echo $row['tanggal_pesanan']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
        
                </tr>
                <?php
            }
        } else {
            echo "Belum ada data pesanan.";
        }
    ?>

</table>
<?php
    include 'templates/footer.php';
?>