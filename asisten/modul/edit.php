<?php
include '../templates/header.php';
include '../../config.php';

if (!isset($_GET['id']) || !isset($_GET['id_praktikum'])) {
    header('Location: ../praktikum/index.php');
    exit;
}
$id = intval($_GET['id']);
$id_praktikum = intval($_GET['id_praktikum']);

// Ambil data lama
$q = mysqli_query($conn, "SELECT * FROM modul WHERE id=$id AND praktikum_id=$id_praktikum");
$row = mysqli_fetch_assoc($q);
if (!$row) {
    echo '<div class="bg-red-200 text-red-800 p-2 mb-2">Data modul tidak ditemukan!</div>';
    include '../templates/footer.php';
    exit;
}

if (isset($_POST['submit'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul_modul']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $file_materi = $row['file_materi'];
    if (!empty($_FILES['file_materi']['name'])) {
        $ext = pathinfo($_FILES['file_materi']['name'], PATHINFO_EXTENSION);
        $nama_file = 'materi_'.time().'_'.rand(100,999).'.'.$ext;
        $tujuan = '../../uploads/materi/'.$nama_file;
        if (move_uploaded_file($_FILES['file_materi']['tmp_name'], $tujuan)) {
            // Hapus file lama jika ada
            if ($row['file_materi'] && file_exists('../../uploads/materi/'.$row['file_materi'])) {
                unlink('../../uploads/materi/'.$row['file_materi']);
            }
            $file_materi = $nama_file;
        }
    }
    $q = "UPDATE modul SET judul_modul='$judul', tanggal='$tanggal', file_materi='$file_materi' WHERE id=$id AND praktikum_id=$id_praktikum";
    if (mysqli_query($conn, $q)) {
        header('Location: index.php?id_praktikum='.$id_praktikum);
        exit;
    } else {
        echo '<div class=\'bg-red-200 text-red-800 p-2 mb-2\'>Gagal mengubah modul!</div>';
    }
}
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Modul</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block mb-1">Judul Modul</label>
            <input type="text" name="judul_modul" class="border p-2 w-full" value="<?php echo htmlspecialchars($row['judul_modul']); ?>" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Tanggal</label>
            <input type="date" name="tanggal" class="border p-2 w-full" value="<?php echo htmlspecialchars($row['tanggal']); ?>" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">File Materi (PDF/DOCX, opsional)</label>
            <?php if ($row['file_materi']): ?>
                <div class="mb-2">
                    <a href="../../uploads/materi/<?php echo htmlspecialchars($row['file_materi']); ?>" target="_blank" class="text-blue-600 underline">Download Materi Lama</a>
                </div>
            <?php endif; ?>
            <input type="file" name="file_materi" accept=".pdf,.doc,.docx" class="border p-2 w-full">
        </div>
        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="index.php?id_praktikum=<?php echo $id_praktikum; ?>" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
<?php include '../templates/footer.php'; ?> 