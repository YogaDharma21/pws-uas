<?php
session_start();
require_once '../classes/users.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $dataUser = new users(); 

    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $no_hp    = trim($_POST['no_hp']);
    $alamat   = trim($_POST['alamat']);

    $id_role  = 2; 
    
    if (empty($nama) || empty($email) || empty($password) || empty($no_hp) || empty($alamat)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    $userLama = $dataUser->readByEmail($email);

    if ($userLama) {
        echo "<script>alert('Email sudah terdaftar! Silakan gunakan email lain.'); window.history.back();</script>";
        exit;
    }

    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    if ($dataUser->create($id_role, $nama, $email, $password_hashed, $no_hp, $alamat)) {
        echo "<script>
            alert('Registrasi berhasil! Silakan login.');
            window.location.href = '../login.php';
        </script>";
    } else {
        echo "<script>alert('Gagal Menyimpan Data');window.location='../register.php'</script>";
    }
} else {
    header('Location: ../register.php');
    exit;
}
?>