<?php
session_start();
require_once '../../classes/users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new users();

    $id_user  = trim($_POST['id_user']);
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $no_hp    = trim($_POST['no_hp']);
    $alamat   = trim($_POST['alamat']);
    $id_role  = trim($_POST['id_role']);

    if (empty($nama) || empty($email) || empty($no_hp) || empty($id_role)) {
        echo "<script>alert('Field penting wajib diisi!'); window.history.back();</script>";
        exit;
    }

    if ($user->update($id_user, $id_role, $nama, $email, $no_hp, $alamat)) {
        echo "<script>
                alert('Data user berhasil diperbarui!');
                window.location.href = '../usersPage.php'; 
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui data user.'); window.history.back();</script>";
    }
} else {
    header('Location: ../usersPage.php');
    exit;
}
?>