<?php
    require_once '../../classes/kategori.php';
    $kategori = new Kategori();
    $dataKategori = $kategori->getAll();

    require_once '../../classes/produk.php';
    $produk = new Produk();
    $data = $produk->readById($_GET['id']);
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
                <h2>Update Produk</h2>
            </div>
            <form action="prosesUpdateProduk.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">  
                    <input type="hidden" name="id_produk" value="<?php echo $data['id_produk'] ?>">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" value="<?php echo $data['nama_produk'] ?>" required>
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
                    <textarea name="deskripsi" rows="1"><?php echo $data['deskripsi'] ?></textarea>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" value="<?php echo $data['harga'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" value="<?php echo $data['stok'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Gambar Produk</label>
                    <input type="file" name="gambar" accept="image/*">
                </div>

                <button type="submit" class="btn-form">Simpan</button>

            </form>
        </div>
    </div>
</body>
</html>