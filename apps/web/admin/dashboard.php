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
    echo "admin dashboard";
    echo "Selamat datang, " . $_SESSION['nama'] . "!";
    echo "<br><a href='../logout.php'>Logout</a>";
?>