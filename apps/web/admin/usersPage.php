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
  
    $page = 'usersPage';

    include 'templates/header.php';
    include 'templates/sidebar.php';
    include 'templates/navbar.php';
?>

<div class="header-action">
    <div class="title-area">
        <h1>Users</h1>
        <p></p>
    </div>
    
    <div class="button-group">
        <a href="../register.php" style="text-decoration: none;">
            <button class="btn-add">+ Tambah User</button>
        </a>
        <a href="produk/tambahProduk.php" style="text-decoration: none;">
            <button class="btn-add">+ Tambah Produk</button>
        </a>
    </div>
</div>

<table class="table">
    <tr>
        <th>ID </th>
        <th>Nama</th>
        <th>Email</th>
        <th>No HP</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    <?php
        require_once '../classes/users.php';
        $user = new Users();
        $dataUser = $user->read();
        if ($dataUser && $dataUser->num_rows > 0) {
            while ($row = $dataUser->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['id_user']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['no_hp']; ?></td>
                    <td><?php echo $row['nama_role']; ?></td>
                    <td>
                        <a href="users/updateUser.php?id=<?php echo $row['id_user']; ?>" class="btn-edit">
                            <i class="bx bx-edit"></i>
                        </a>
                        <a href="users/hapusUser.php?action=delete&id=<?php echo $row['id_user']; ?>" class="btn-delete" style="color: #ef4444;">
                            <i class="bx bx-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='8' style='text-align:center;'>Belum ada data user.</td></tr>";
        }
    ?>

</table>

<?php
    include 'templates/footer.php';
?>