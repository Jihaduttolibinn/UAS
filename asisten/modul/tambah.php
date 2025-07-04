<?php
include '../templates/header.php';
include '../../config.php';

if (!isset($_GET['id_praktikum'])) {
    header('Location: ../praktikum/index.php');
    exit;
}
$id_praktikum = intval($_GET['id_praktikum']);

if (isset($_POST['submit'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul_modul']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $file_materi = null;
    if (!empty($_FILES['file_materi']['name'])) {
        $ext = pathinfo($_FILES['file_materi']['name'], PATHINFO_EXTENSION);
        $nama_file = 'materi_'.time().'_'.rand(100,999).'.'.$ext;
        $tujuan = '../../uploads/materi/'.$nama_file;
        if (move_uploaded_file($_FILES['file_materi']['tmp_name'], $tujuan)) {
            $file_materi = $nama_file;
        }
    }
    $q = "INSERT INTO modul (praktikum_id, judul_modul, file_materi, tanggal) VALUES ($id_praktikum, '$judul', '$file_materi', '$tanggal')";
    if (mysqli_query($conn, $q)) {
        header('Location: index.php?id_praktikum='.$id_praktikum);
        exit;
    } else {
        echo '<div class="bg-red-200 text-red-800 p-2 mb-2">Gagal menambah modul!</div>';
    }
}
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Modul</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block mb-1">Judul Modul</label>
            <input type="text" name="judul_modul" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Tanggal</label>
            <input type="date" name="tanggal" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">File Materi (PDF/DOCX, opsional)</label>
            <input type="file" name="file_materi" accept=".pdf,.doc,.docx" class="border p-2 w-full">
        </div>
        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="index.php?id_praktikum=<?php echo $id_praktikum; ?>" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
<?php include '../templates/footer.php'; ?> 