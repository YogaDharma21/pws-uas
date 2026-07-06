<?php
    require_once '../../classes/pesanan.php';
    $pesanan = new pesanan();
    $id_pesanan = $_GET['id'];
    
    $data = $pesanan->readById($id_pesanan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/pesanan.css">
    <link rel="stylesheet" href="../../assets/admin.css">
</head>
<body>

    <div class="detail-container">
        <div class="invoice-card">
            <div class="invoice-header">
                <h2>Detail Pesanan</h2>
            </div>
            <div class="invoice-body">
                <p><span class="label"><strong>ID Pesanan</strong></span>: <?php echo $data['midtrans_order_id']; ?></p>
                <p><span class="label"><strong>Tanggal Pemesanan</strong></span>: <?php echo $data['tanggal_pesanan']; ?></p>
                <p><span class="label"><strong>Nama Pelanggan</strong></span>: <?php echo $data['nama']; ?></p>
                <p><span class="label"><strong>Email</strong></span>: <?php echo $data['email']; ?></p>
                <p><span class="label"><strong>No HP</strong></span>: <?php echo $data['no_hp']; ?></p>
                <p><span class="label"><strong>Alamat</strong></span>: <?php echo $data['alamat']; ?></p>
                <p><span class="label"><strong>Status Pesanan</strong></span>: <?php echo $data['status_pesanan']; ?></p>
                <p><span class="label"><strong>Status Pembayaran</strong></span>: <?php echo $data['status_pembayaran']; ?></p>
                <p><span class="label"><strong>Metode Pembayaran</strong></span>: <?php echo $data['metode_pembayaran']; ?></p>
                <p><span class="label"><strong>Total Harga</strong></span>: Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></p>
            </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../../classes/detailPsn.php';
                        $dPesanan = new detailPsn();
                        $id_pesanan = $_GET['id'];
                        
                        $item = $dPesanan->readDetail($id_pesanan);
                        
                        if ($item && $item->num_rows > 0) {
                            while ($row = $item->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $row['nama_produk']; ?></td>
                                    
                                    <td>Rp <?php echo number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
                                    
                                    <td><?php echo $row['jumlah']; ?> pcs</td>
                                    
                                    <td>Rp <?php echo number_format($row['subtotal'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "Belum ada data produk untuk pesanan ini";
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <div class="button-group">
                    <a href="" style="text-decoration: none;">
                        <button class="btn-add">Cetak Invoice</button>
                    </a>
                    <a href="../pesananPage.php" style="text-decoration: none;">
                        <button class="btn-add">Kembali</button>
                    </a>
                </div>
        </div>
    </div>

</body>
</html>