<?php
include '../templates/header.php';
include '../../config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);

// Ambil data lama
$q = mysqli_query($conn, "SELECT * FROM praktikum WHERE id=$id");
$row = mysqli_fetch_assoc($q);
if (!$row) {
    echo '<div class="bg-red-200 text-red-800 p-2 mb-2">Data tidak ditemukan!</div>';
    include '../templates/footer.php';
    exit;
}

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_praktikum']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $q = "UPDATE praktikum SET nama_praktikum='$nama', deskripsi='$deskripsi' WHERE id=$id";
    if (mysqli_query($conn, $q)) {
        header('Location: index.php');
        exit;
    } else {
        echo '<div class="bg-red-200 text-red-800 p-2 mb-2">Gagal mengubah data!</div>';
    }
}
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Mata Praktikum</h1>
    <form method="post">
        <div class="mb-4">
            <label class="block mb-1">Nama Praktikum</label>
            <input type="text" name="nama_praktikum" class="border p-2 w-full" value="<?php echo htmlspecialchars($row['nama_praktikum']); ?>" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Deskripsi</label>
            <textarea name="deskripsi" class="border p-2 w-full" required><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>
        </div>
        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="index.php" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
<?php include '../templates/footer.php'; ?> 