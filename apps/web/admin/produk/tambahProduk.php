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
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Document</title>
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>Input Produk</h2>
            </div>
            <form action="prosesTambahProduk.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                            while($row = $dataKategori->fetch_assoc()){
                                echo "<option value='".$row['id_kategori']."'>".$row['nama_kategori']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" rows="1"></textarea>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" required>
                </div>

                <div class="form-group">
                    <label>Gambar Produk</label>
                    <input type="file" name="gambar" accept="image/*" class="file-input">
                </div>

                <button type="submit" class="btn-form">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>