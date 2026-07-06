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
                <td><?php echo $row['nama_kategori']; ?></td>
                <td>
                    <div class="aksi-group">
                        <a href="kategori/updateKategori.php?id=<?php echo $row['id_kategori']; ?> "style="color: #ffffff;">
                            Edit
                        </a>
                        <a href="kategori/prosesKategori.php?action=delete&id=<?php echo $row['id_kategori']; ?>"style="color: #ef4444;">
                            Hapus
                        </a>
                    </div>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "Belum ada data kategori.";
    }
?>
</table>

<?php
    include 'templates/footer.php';
?>