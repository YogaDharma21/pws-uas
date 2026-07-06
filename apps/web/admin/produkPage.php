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
<link rel="stylesheet" href="../assets/admin.css">
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
                        <div class="aksi-group">
                            <a href="produk/updateProduk.php?id=<?php echo $row['id_produk']; ?> "style="color: #ffffff;">
                                Edit
                            </a>
                            <a href="produk/prosesProduk.php?action=delete&id=<?php echo $row['id_produk']; ?>"style="color: #ef4444;">
                                Hapus
                            </a>
                        </div>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "Belum ada data produk.";
        }
    ?>

</table>

<?php
    include 'templates/footer.php';
?>