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

    $page = 'pesananPage'; 

    include 'templates/header.php';
    include 'templates/sidebar.php';
    include 'templates/navbar.php';
?>

<div class="header-action">
    <div class="title-area">
        <h1>Pesanan</h1>
    </div>
    <div class="button-group">
        <a  href="pesanan/cetakLaporan.php" target="_blank" style="text-decoration: none;">
            <button class="btn-add">Export PDF</button>
        </a>
    </div>
    
</div>

<table class="table">
    <tr>
        <th>ID </th>
        <th>Tanggal</th>
        <th>Nama Customer</th>
        <th>Total</th>
        <th>Status Pesanan</th>
        <th>Status Pembayaran</th>
        <th>Aksi</th>
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
                    <td><?php echo $row['status_pesanan']; ?></td>
                    <td><?php echo $row['status_pembayaran']; ?></td>
                    <td>
                        <div class="aksi-group">
                            <a href="pesanan/updatePesanan.php?id=<?php echo $row['id_pesanan']; ?> "style="color: #ffffff;">
                                Edit
                            </a>
                            <a href="detailpesanan/detailPesanan.php?id=<?php echo $row['id_pesanan']; ?>" style="color: #ffffff;">
                                Detail
                            </a>
                        </div>
                    </td>
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