<?php
include '../templates/header.php';
include '../../config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);

// Ambil data laporan
$q = mysqli_query($conn, "SELECT laporan.*, users.nama AS nama_mahasiswa, users.email, modul.judul_modul, praktikum.nama_praktikum FROM laporan JOIN users ON laporan.user_id = users.id JOIN modul ON laporan.modul_id = modul.id JOIN praktikum ON modul.praktikum_id = praktikum.id WHERE laporan.id=$id");
$row = mysqli_fetch_assoc($q);
if (!$row) {
    echo '<div class=\'bg-red-200 text-red-800 p-2 mb-2\'>Data laporan tidak ditemukan!</div>';
    include '../templates/footer.php';
    exit;
}

if (isset($_POST['submit'])) {
    $nilai = floatval($_POST['nilai']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
    $q = "UPDATE laporan SET nilai=$nilai, feedback='$feedback', status='dinilai' WHERE id=$id";
    if (mysqli_query($conn, $q)) {
        header('Location: index.php');
        exit;
    } else {
        echo '<div class=\'bg-red-200 text-red-800 p-2 mb-2\'>Gagal menyimpan penilaian!</div>';
    }
}
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detail Laporan</h1>
    <div class="mb-4">
        <strong>Mahasiswa:</strong> <?php echo htmlspecialchars($row['nama_mahasiswa']); ?> (<?php echo htmlspecialchars($row['email']); ?>)<br>
        <strong>Praktikum:</strong> <?php echo htmlspecialchars($row['nama_praktikum']); ?><br>
        <strong>Modul:</strong> <?php echo htmlspecialchars($row['judul_modul']); ?><br>
        <strong>Tanggal Upload:</strong> <?php echo htmlspecialchars($row['tanggal_upload']); ?><br>
        <strong>File Laporan:</strong> <a href="../../uploads/laporan/<?php echo htmlspecialchars($row['file_laporan']); ?>" target="_blank" class="text-blue-600 underline">Download</a><br>
        <strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?><br>
        <strong>Nilai:</strong> <?php echo is_null($row['nilai']) ? '-' : htmlspecialchars($row['nilai']); ?><br>
        <strong>Feedback:</strong> <?php echo $row['feedback'] ? nl2br(htmlspecialchars($row['feedback'])) : '-'; ?><br>
    </div>
    <?php if ($row['status'] !== 'dinilai'): ?>
    <form method="post">
        <div class="mb-4">
            <label class="block mb-1">Nilai (0-100)</label>
            <input type="number" name="nilai" min="0" max="100" step="0.01" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Feedback</label>
            <textarea name="feedback" class="border p-2 w-full" required></textarea>
        </div>
        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Penilaian</button>
        <a href="index.php" class="ml-2 text-gray-600">Kembali</a>
    </form>
    <?php else: ?>
        <a href="index.php" class="text-blue-600 underline">Kembali ke Laporan Masuk</a>
    <?php endif; ?>
</div>
<?php include '../templates/footer.php'; ?> 