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
    $page = 'kategoriPage'; 

    include 'templates/header.php';
    include 'templates/sidebar.php';
    include 'templates/navbar.php';
?>

<div class="header-action">
    <div class="title-area">
        <h1>Data Kategori</h1>
        <p></p>
    </div>
    
    <div class="button-group">
        <a href="kategori/tambahKategori.php" style="text-decoration: none;">
            <button class="btn-add">+ Tambah Kategori</button>
        </a>
    </div>
</div>

<table class="table">
    <tr>
        <th>ID</th>
        <th>Nama Kategori</th>
        <th>Action</th>
    </tr>
<?php
    require_once '../classes/kategori.php';
    $kategori = new kategori();
    $dataKategori = $kategori->getAll();
    if ($dataKategori && $dataKategori->num_rows > 0) {
        while ($row = $dataKategori->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['id_kategori']; ?></td>
                <td><strong><?php echo $row['nama_kategori']; ?></strong></td>
                <td>
                    <a href="kategori/updateKategori.php?id=<?php echo $row['id_kategori']; ?>" class="btn-edit">
                        <i class="bx bx-edit"></i>
                    </a>
                    <a href="kategori/prosesKategori.php?action=delete&id=<?php echo $row['id_kategori']; ?>" class="btn-delete" style="color: #ef4444;">
                            <i class="bx bx-trash"></i>
                    </a>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='3' style='text-align:center;'>Belum ada data kategori.</td></tr>";
    }
?>
</table>

<?php
    include 'templates/footer.php';
?>