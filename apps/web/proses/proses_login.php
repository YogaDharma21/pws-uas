<?php
session_start();
require_once '../classes/users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user = new users();

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "<script>alert('Email dan Password wajib diisi!'); window.history.back();</script>";
        exit;
    }

    $dataUser = $user->readByEmail($email);

    if ($dataUser) {
        if (password_verify($password, $dataUser['password'])) {
            
            $_SESSION['id_user']  = $dataUser['id_user'];
            $_SESSION['email'] = $dataUser['email'];
            $_SESSION['id_role']  = $dataUser['id_role'];
            $_SESSION['nama']     = $dataUser['nama'];

            if ($_SESSION['id_role'] == 1) {
                echo "<script>
                    alert('Selamat datang Admin, " . $dataUser['nama'] . "!');
                    window.location.href = '../admin/dashboard.php';
                </script>";
            } else {
                echo "<script>
                    alert('Login berhasil! Selamat berbelanja.');
                    window.location.href = '../index.php';
                </script>";
            }
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Email tidak terdaftar!'); window.history.back();</script>";
        exit;
    }
} else {
    header('Location: ../login.php');
    exit;
}
?>