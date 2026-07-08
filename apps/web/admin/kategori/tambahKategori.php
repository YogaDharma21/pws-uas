<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        echo 
        "<script>
            alert('Anda harus login terlebih dahulu!'); 
            window.location.href = '../../login.php';
        </script>";
        exit;   
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Document</title>
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>Masukkan Kategori</h2>
            </div>
            <form action="prosesTambahKategori.php" method= "POST">
                <div class="form-group">
                    <label for="nama">Nama Kategori :</label>
                    <input type="text" name="nama">
                </div>
                <button type="submit" value="simpan" class="btn-form">submit</button>
            </form>
        </div>
    </div>
</body>
</html>