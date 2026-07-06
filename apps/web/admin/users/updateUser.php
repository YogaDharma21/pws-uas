<?php
    require_once '../../classes/role.php';
    $role = new Role();
    $dataRole = $role->getAll();

    require_once '../../classes/users.php';
    $user = new users(); 
    $data = $user->readById($_GET['id']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Document</title>
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>Data User</h2>
            </div>
            <form action="prosesUpdateUser.php" method="POST">
            <div class="form-group">
                <input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">
                <label>Nama</label>
                <input type="text" name="nama" value="<?= $data['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= $data['email']; ?>" required>
            </div>
            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp"value="<?= $data['no_hp']; ?>" required>
            </div>
            <div class="form-group"> 
                <label>Alamat</label>
                <textarea name="alamat"><?= $data['alamat']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="id_role" required>
                    <option value="">-- Pilih Role --</option>
                    <?php
                        while($row = $dataRole->fetch_assoc()){
                            echo "<option value='".$row['id_role']."'>".$row['nama_role']."</option>";
                        }
                    ?>
                </select>
            </div>
            
            <button type="submit" class="btn-form">Update</button>

        </form>
</body>
</html>