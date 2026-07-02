<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Data Kategori</h2>
        <?php
            require_once '../../classes/kategori.php';
            $kategori = new kategori();
            $data = $kategori->getByID($_GET['id']);
        ?>
        <form action="prosesUpdateKategori.php" method= "POST">
            <label for="nama">Nama Kategori :</label>
            <input type="text" name="nama" value="<?php echo $data['nama_kategori']; ?>"><br>
            <input type="hidden" name="id" value ="<?php echo $data['id_kategori']; ?>"><br>
    
        <button type="submit" value="simpan">Update</button>
    </form>
</body>
</html>