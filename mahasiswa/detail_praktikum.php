<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: ../login.php');
    exit;
}
include __DIR__.'/templates/header_mahasiswa.php';
include __DIR__.'/../config.php';

if (!isset($_GET['id'])) {
    header('Location: praktikum_saya.php');
    exit;
}
$user_id = intval($_SESSION['user_id']);
$praktikum_id = intval($_GET['id']);
// Cek apakah user sudah mendaftar praktikum ini
$cek = mysqli_query($conn, "SELECT id FROM pendaftaran WHERE user_id=$user_id AND praktikum_id=$praktikum_id");
if (mysqli_num_rows($cek) == 0) {
    header('Location: praktikum_saya.php');
    exit;
}
// Ambil info praktikum
$praktikum = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM praktikum WHERE id=$praktikum_id"));
// Ambil modul
$modul = mysqli_query($conn, "SELECT * FROM modul WHERE praktikum_id=$praktikum_id ORDER BY tanggal ASC, id ASC");
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-2">Detail Praktikum: <?php echo htmlspecialchars($praktikum['nama_praktikum']); ?></h1>
    <div class="mb-4 text-gray-700"><?php echo htmlspecialchars($praktikum['deskripsi']); ?></div>
    <h2 class="text-xl font-semibold mb-2">Daftar Modul</h2>
    <table class="min-w-full bg-white border mb-8">
        <thead>
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Judul Modul</th>
                <th class="border px-4 py-2">Materi</th>
                <th class="border px-4 py-2">Laporan</th>
                <th class="border px-4 py-2">Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($modul)): ?>
            <tr>
                <td class="border px-4 py-2"><?php echo $no++; ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['judul_modul']); ?></td>
                <td class="border px-4 py-2">
                    <?php if ($row['file_materi']): ?>
                        <a href="../uploads/materi/<?php echo htmlspecialchars($row['file_materi']); ?>" target="_blank" class="text-blue-600 underline">Download</a>
                    <?php else: ?>
                        <span class="text-gray-400">-</span>
                    <?php endif; ?>
                </td>
                <td class="border px-4 py-2">
                    <?php
                    // Cek laporan
                    $lap = mysqli_query($conn, "SELECT * FROM laporan WHERE user_id=$user_id AND modul_id=".$row['id']);
                    $laporan = mysqli_fetch_assoc($lap);
                    if ($laporan):
                        echo '<a href="../uploads/laporan/'.htmlspecialchars($laporan['file_laporan']).'" target="_blank" class="text-blue-600 underline">Lihat Laporan</a>';
                        if ($laporan['status'] == 'dinilai') {
                            echo '<br><span class="text-green-600">Sudah Dinilai</span>';
                        } else {
                            echo '<br><span class="text-yellow-600">Belum Dinilai</span>';
                        }
                    else:
                    ?>
                        <form method="post" enctype="multipart/form-data" style="display:inline" action="upload_laporan.php">
                            <input type="hidden" name="modul_id" value="<?php echo $row['id']; ?>">
                            <input type="file" name="file_laporan" accept=".pdf,.doc,.docx" required class="inline-block border p-1">
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Upload</button>
                        </form>
                    <?php endif; ?>
                </td>
                <td class="border px-4 py-2">
                    <?php
                    if ($laporan && $laporan['status'] == 'dinilai') {
                        echo htmlspecialchars($laporan['nilai']) . '<br>';
                        echo '<span class="text-gray-600">' . nl2br(htmlspecialchars($laporan['feedback'])) . '</span>';
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="praktikum_saya.php" class="text-blue-600 underline">Kembali ke Praktikum Saya</a>
</div>
<?php include __DIR__.'/templates/footer_mahasiswa.php'; ?> 