<?php
    session_start();

    if(isset($_SESSION['email'])){
        header('Location: index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<form action="proses/proses_register.php" method="POST">
    <label>Nama :</label>
    <input type="text" name="nama" required>
    <br><br>

    <label>Email :</label>
    <input type="email" name="email" required>
    <br><br>

    <label>Password :</label>
    <input type="password" name="password" required>
    <br><br>

    <label>No. HP :</label>
    <input type="text" name="no_hp" required>
    <br><br>

    <label>Alamat :</label>
    <textarea name="alamat" required></textarea>
    <br><br>

    <button type="submit">Daftar</button>

</form>

<p>Sudah punya akun? <a href="login.php">Login</a></p>

</body>
</html>