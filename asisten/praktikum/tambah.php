<?php
include '../templates/header.php';
include '../../config.php';

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_praktikum']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $q = "INSERT INTO praktikum (nama_praktikum, deskripsi) VALUES ('$nama', '$deskripsi')";
    if (mysqli_query($conn, $q)) {
        header('Location: index.php');
        exit;
    } else {
        echo '<div class="bg-red-200 text-red-800 p-2 mb-2">Gagal menambah data!</div>';
    }
}
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Mata Praktikum</h1>
    <form method="post">
        <div class="mb-4">
            <label class="block mb-1">Nama Praktikum</label>
            <input type="text" name="nama_praktikum" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Deskripsi</label>
            <textarea name="deskripsi" class="border p-2 w-full" required></textarea>
        </div>
        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="index.php" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
<?php include '../templates/footer.php'; ?> 