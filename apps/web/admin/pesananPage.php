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
        <p></p>
    </div>
    
    <div class="button-group">
        <button class="btn-export">Export Data </button>
        <button class="btn-add">+ Tambah Pesanan</button>
    </div>
</div>



<?php
    include 'templates/footer.php';
?>