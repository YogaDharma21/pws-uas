<?php
    require_once '../../classes/kategori.php';
    $kategori = new Kategori();
    $dataKategori = $kategori->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Input Produk</h2>
    <form action="prosesTambahProduk.php" method="POST" enctype="multipart/form-data">
        <label>Nama Produk</label><br>
        <input type="text" name="nama_produk" required><br><br>
        <label>Kategori</label><br>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
                while($row = $dataKategori->fetch_assoc()){
                    echo "<option value='".$row['id_kategori']."'>".$row['nama_kategori']."</option>";
                }
            ?>
        </select><br><br>

        <label>Deskripsi</label><br>
        <textarea name="deskripsi" rows="5"></textarea><br><br>

        <label>Harga</label><br>
        <input type="number" name="harga" required><br><br>

        <label>Stok</label><br>
        <input type="number" name="stok" required><br><br>

        <label>Gambar Produk</label><br>
        <input type="file" name="gambar" accept="image/*"><br><br>

        <button type="submit">Simpan</button>

    </form>
</body>
</html>