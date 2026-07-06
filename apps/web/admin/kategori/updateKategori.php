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
                <h2>Data Kategori</h2>
            </div>
            <?php
                require_once '../../classes/kategori.php';
                $kategori = new kategori();
                $data = $kategori->getByID($_GET['id']);
            ?>
            <form action="prosesUpdateKategori.php" method= "POST">
                <div class="form-group">
                    <label for="nama">Nama Kategori :</label>
                    <input type="text" name="nama" value="<?php echo $data['nama_kategori']; ?>"><br>
                    <input type="hidden" name="id" value ="<?php echo $data['id_kategori']; ?>"><br>
                </div>
                <button type="submit" value="simpan" class="btn-form">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
