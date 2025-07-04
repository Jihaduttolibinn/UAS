<?php
include '../templates/header.php';
include '../../config.php';

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    // Cek email unik
    $cek = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo '<div class="bg-red-200 text-red-800 p-2 mb-2">Email sudah terdaftar!</div>';
    } else {
        $q = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')";
        if (mysqli_query($conn, $q)) {
            header('Location: index.php');
            exit;
        } else {
            echo '<div class="bg-red-200 text-red-800 p-2 mb-2">Gagal menambah user!</div>';
        }
    }
}
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah User</h1>
    <form method="post">
        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Role</label>
            <select name="role" class="border p-2 w-full" required>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="asisten">Asisten</option>
            </select>
        </div>
        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="index.php" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
<?php include '../templates/footer.php'; ?> 