<?php
include '../templates/header.php';
include '../../config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);

// Ambil data lama
$q = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$row = mysqli_fetch_assoc($q);
if (!$row) {
    echo '<div class=\'bg-red-200 text-red-800 p-2 mb-2\'>User tidak ditemukan!</div>';
    include '../templates/footer.php';
    exit;
}

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = $_POST['password'];
    // Cek email unik (kecuali milik user ini sendiri)
    $cek = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' AND id<>$id");
    if (mysqli_num_rows($cek) > 0) {
        echo '<div class=\'bg-red-200 text-red-800 p-2 mb-2\'>Email sudah terdaftar!</div>';
    } else {
        $q = "UPDATE users SET nama='$nama', email='$email', role='$role'";
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $q .= ", password='$hash'";
        }
        $q .= " WHERE id=$id";
        if (mysqli_query($conn, $q)) {
            header('Location: index.php');
            exit;
        } else {
            echo '<div class=\'bg-red-200 text-red-800 p-2 mb-2\'>Gagal mengubah user!</div>';
        }
    }
}
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>
    <form method="post">
        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" class="border p-2 w-full" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="border p-2 w-full" value="<?php echo htmlspecialchars($row['email']); ?>" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Password (kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="border p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1">Role</label>
            <select name="role" class="border p-2 w-full" required>
                <option value="mahasiswa" <?php if($row['role']=='mahasiswa') echo 'selected'; ?>>Mahasiswa</option>
                <option value="asisten" <?php if($row['role']=='asisten') echo 'selected'; ?>>Asisten</option>
            </select>
        </div>
        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="index.php" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
<?php include '../templates/footer.php'; ?> 