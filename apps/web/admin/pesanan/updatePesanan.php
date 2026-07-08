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
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
     <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>Update Pesanan</h2>
            </div>
            <?php
                require_once '../../classes/pesanan.php';
                $pesanan = new Pesanan();
                $data = $pesanan->readByID($_GET['id']);
            ?>
            <form action="prosesUpdatePesanan.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">  
                    <input type="hidden" name="id_pesanan" value="<?php echo $data['id_pesanan']; ?>">
                    <label>Tanggal Pesanan</label>
                    <input type="text" value="<?php echo $data['tanggal_pesanan']; ?>" readonly >
                </div>
                <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="text" value="<?php echo $data['nama'] ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Total</label>
                    <input type="text" value="<?php echo $data['total_harga'] ?>" readonly>
                </div>
            
                <div class="form-group">
                    <label>Status Pesanan</label>

                    <select name="status_pesanan" required>

                        <option value="Pending"
                            <?php if($data['status_pesanan'] == "Pending") echo "selected"; ?>>
                            Pending
                        </option>

                        <option value="Diproses"
                            <?php if($data['status_pesanan'] == "Diproses") echo "selected"; ?>>
                            Diproses
                        </option>

                        <option value="Dikirim"
                            <?php if($data['status_pesanan'] == "Dikirim") echo "selected"; ?>>
                            Dikirim
                        </option>

                        <option value="Selesai"
                            <?php if($data['status_pesanan'] == "Selesai") echo "selected"; ?>>
                            Selesai
                        </option>

                        <option value="Dibatalkan"
                            <?php if($data['status_pesanan'] == "Dibatalkan") echo "selected"; ?>>
                            Dibatalkan
                        </option>

                    </select>
                </div>

                <div class="form-group">
                    <label>Status Pembayaran</label>

                    <select name="status_pembayaran" required>

                        <option value="Pending"
                            <?php if($data['status_pembayaran'] == "Pending") echo "selected"; ?>>
                            Pending
                        </option>

                        <option value="Paid"
                            <?php if($data['status_pembayaran'] == "Paid") echo "selected"; ?>>
                            Paid
                        </option>

                        <option value="Expired"
                            <?php if($data['status_pembayaran'] == "Expired") echo "selected"; ?>>
                            Expired
                        </option>

                        <option value="Cancelled"
                            <?php if($data['status_pembayaran'] == "Cancelled") echo "selected"; ?>>
                            Cancelled
                        </option>

                    </select>
                </div>

                <button type="submit" class="btn-form">Simpan</button>

            </form>
        </div>
    </div>
</body>
</html>