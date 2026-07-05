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
    <title>Document</title>
</head>
<body>
    <form action="prosesUpdateUser.php" method="POST">

    <input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">

    <label>Nama</label><br>
    <input type="text" name="nama"
           value="<?= $data['nama']; ?>" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email"
           value="<?= $data['email']; ?>" required><br><br>

    <label>No HP</label><br>
    <input type="text" name="no_hp"
           value="<?= $data['no_hp']; ?>" required><br><br>

    <label>Alamat</label><br>
    <textarea name="alamat"><?= $data['alamat']; ?></textarea><br><br>

    <label>Role</label><br>

    <select name="id_role" required>
            <option value="">-- Pilih Role --</option>
            <?php
                while($row = $dataRole->fetch_assoc()){
                    echo "<option value='".$row['id_role']."'>".$row['nama_role']."</option>";
                }
            ?>
        </select><br><br>
    
    <button type="submit">Update</button>

</form>
</body>
</html>