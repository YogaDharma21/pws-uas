<?php
session_start();
if (isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <div class="form-container">
        <div class="form-card">
            
            <div class="form-header">
                <h2>Selamat Datang</h2>
                <p>Masuk ke akun Anda untuk menikmati fitur penuh</p>
            </div>

            <form action="proses/proses_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nama@example.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-form">Login</button>
            </form>

            <div class="form-footer">
                <p>Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
            </div>

        </div>
    </div>

</body>
</html>