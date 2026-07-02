<?php
session_start();

require_once '../config/database.php'; 
require_once '../config/midtrans_config.php'; 

if (!isset($_SESSION['id_user'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    header('Location: ../keranjang.php');
    exit;
}

$id_user = $_SESSION['id_user'];

$db_obj = new database();
$koneksi = $db_obj->conn;

$query_user = $koneksi->query("SELECT * FROM users WHERE id_user = '$id_user'");
$data_user = $query_user->fetch_assoc();

$total_harga = 0;
$detail_items = [];      
$midtrans_items = [];    

foreach ($_SESSION['keranjang'] as $id_produk => $qty) {
    $id_produk_aman = $koneksi->real_escape_string($id_produk);
    $query_prod = $koneksi->query("SELECT * FROM produk WHERE id_produk = '$id_produk_aman'");
    
    if ($query_prod && $query_prod->num_rows > 0) {
        $prod = $query_prod->fetch_assoc();
        $harga_satuan = $prod['harga'];
        $subtotal = $harga_satuan * $qty;
        
        $total_harga += $subtotal;
        
        $detail_items[] = [
            'id_produk'    => $id_produk_aman,
            'jumlah'       => $qty,
            'harga_satuan' => $harga_satuan,
            'subtotal'     => $subtotal
        ];

        $midtrans_items[] = [
            'id'       => $prod['id_produk'],
            'price'    => (int)$harga_satuan,
            'quantity' => (int)$qty,
            'name'     => substr($prod['nama_produk'], 0, 50) 
        ];
    }
}

$midtrans_order_id = 'TZN-' . time();

$koneksi->begin_transaction();

try {
    $sql_pesanan = "INSERT INTO pesanan (id_user, total_harga, status_pesanan, status_pembayaran, midtrans_order_id) 
                    VALUES (?, ?, 'Pending', 'Pending', ?)";
    
    $stmt_pesanan = $koneksi->prepare($sql_pesanan);
    if (!$stmt_pesanan) {
        throw new Exception("Gagal menyiapkan statement pesanan: " . $koneksi->error);
    }
    
    $stmt_pesanan->bind_param("ids", $id_user, $total_harga, $midtrans_order_id);
    $stmt_pesanan->execute();
    
    $id_pesanan_baru = $koneksi->insert_id;
    $stmt_pesanan->close();

    $sql_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga_satuan, subtotal) 
                   VALUES (?, ?, ?, ?, ?)";
    $stmt_detail = $koneksi->prepare($sql_detail);
    if (!$stmt_detail) {
        throw new Exception("Gagal menyiapkan statement detail pesanan: " . $koneksi->error);
    }

    foreach ($detail_items as $item) {
        $stmt_detail->bind_param(
            "iiidd", 
            $id_pesanan_baru, 
            $item['id_produk'], 
            $item['jumlah'], 
            $item['harga_satuan'], 
            $item['subtotal']
        );
        $stmt_detail->execute();
    }
    $stmt_detail->close();

    $koneksi->commit();

    $transaction_details = [
        'order_id'     => $midtrans_order_id,
        'gross_amount' => (int)$total_harga,
    ];

    $customer_details = [
        'first_name' => $data_user['nama'],
        'email'      => $data_user['email'],
        'phone'      => $data_user['no_hp'] ?? '',
        'billing_address' => [
            'first_name' => $data_user['nama'],
            'address'    => $data_user['alamat'] ?? '',
        ]
    ];

    $transaction_params = [
        'transaction_details' => $transaction_details,
        'item_details'        => $midtrans_items,
        'customer_details'    => $customer_details
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($transaction_params);

    unset($_SESSION['keranjang']);

} catch (Exception $e) {
    $koneksi->rollback();
    die("Gagal memproses checkout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - TECHNO ZONE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo \Midtrans\Config::$clientKey; ?>"></script>
</head>
<body class="bg-light">

    <div class="container my-5 text-center">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-5">
                    <h3 class="fw-bold text-success mb-3">Pesanan Anda Berhasil Dibuat!</h3>
                    <p class="text-muted">Klik tombol di bawah ini untuk melakukan pembayaran menggunakan Midtrans Payment Gateway.</p>
                    
                    <div class="my-4 p-3 bg-light rounded text-start">
                        <strong>Detail Ringkas:</strong> <br>
                        <small class="text-muted">Order ID : <?php echo $midtrans_order_id; ?></small> <br>
                        <small class="text-muted">Total Bayar: </small> <strong class="text-danger">Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></strong>
                    </div>

                    <button id="pay-button" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm py-3">BAYAR SEKARANG</button>
                    <a href="../index.php" class="btn btn-link text-secondary mt-3 text-decoration-none">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('<?php echo $snapToken; ?>', {
            onSuccess: function(result){
                window.location.href = 'proses_sukses.php?order_id=' + result.order_id + '&method=' + result.payment_type;
            },
            onPending: function(result){
                alert("Menunggu pembayaran Anda!"); 
                window.location.href = '../index.php'; 
            },
            onError: function(result){
                alert("Pembayaran Gagal!"); 
                console.log(result);
            },
            onClose: function(){
                alert('Anda menutup halaman pembayaran sebelum selesai.');
            }
        });
    });
</script>
</body>
</html>