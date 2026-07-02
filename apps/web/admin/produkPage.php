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
    $page = 'produkPage'; 

    include 'templates/header.php';
    include 'templates/sidebar.php';
    include 'templates/navbar.php';
?>

<div class="header-action">
    <div class="title-area">
        <h1>Data Produk</h1>
        <p></p>
    </div>
    
    <div class="button-group">
        <a href="produk/tambahProduk.php" style="text-decoration: none;">
            <button class="btn-add">+ Tambah Produk</button>
        </a>
    </div>
</div>

<table class="table">
    <tr>
        <th>ID </th>
        <th>Kategori</th>
        <th>Gambar</th>
        <th>Deskripsi</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
    <?php
        require_once '../classes/produk.php';
        $produk = new Produk();
        $dataProduk = $produk->read();
        if ($dataProduk && $dataProduk->num_rows > 0) {
            while ($row = $dataProduk->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['id_produk']; ?></td>
                    <td><?php echo $row['nama_kategori']; ?></td>
                    <td><img src="../assets/img/<?php echo $row['gambar']; ?>" alt="Gambar Produk" width="50"></td>
                    <td class="textarea"><?php echo $row['deskripsi']; ?></td>
                    <td><?php echo $row['nama_produk']; ?></td>
                    <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['stok'] . ' ' . $produk->cekStatusStok($row['stok']); ?></td>
                    <td>
                        <a href="produk/updateProduk.php?id=<?php echo $row['id_produk']; ?>" class="btn-edit">
                            <i class="bx bx-edit"></i>
                        </a>
                        <a href="produk/prosesProduk.php?action=delete&id=<?php echo $row['id_produk']; ?>" class="btn-delete" style="color: #ef4444;">
                            <i class="bx bx-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='8' style='text-align:center;'>Belum ada data produk.</td></tr>";
        }
    ?>

</table>

<?php
    include 'templates/footer.php';
?>