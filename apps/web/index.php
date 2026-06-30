<?php
    session_start();
    echo "Menu Utama";
    echo "Selamat datang, " . $_SESSION['nama'] . "!";
    echo "<br><a href='login.php'>Login</a>";
    echo "<br><a href='logout.php'>Logout</a>";
?>