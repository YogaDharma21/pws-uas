<?php
    require_once '../../classes/users.php';
    $user = new users();

    if (isset($_GET['id'])) {
        $id = $_GET['id']; 
        
        if ($user->delete($id)) {
            echo "<script>alert('Berhasil hapus Data');window.location.href = '../usersPage.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal hapus Data');window.location.href = '../usersPage.php';</script>";
            exit;
        }
    } else {
        header('Location: ../usersPage.php');
        exit;
    }
?>