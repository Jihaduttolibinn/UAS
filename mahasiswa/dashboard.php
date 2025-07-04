<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: ../login.php');
    exit;
}
include __DIR__.'/templates/header_mahasiswa.php';
include __DIR__.'/../config.php';

$user_id = intval($_SESSION['user_id']);

// Query ringkasan data
$jumlah_praktikum = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM pendaftaran WHERE user_id=$user_id"))[0];
$jumlah_laporan = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM laporan WHERE user_id=$user_id"))[0];
$jumlah_dinilai = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM laporan WHERE user_id=$user_id AND status='dinilai'"))[0];

// (Opsional) Daftar praktikum terakhir diikuti
$praktikum_terakhir = mysqli_query($conn, "
    SELECT p.nama_praktikum, p.deskripsi
    FROM praktikum p
    JOIN pendaftaran d ON p.id = d.praktikum_id
    WHERE d.user_id = $user_id
    ORDER BY d.tanggal_daftar DESC
    LIMIT 3
");
?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard Mahasiswa</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-blue-100 p-4 rounded text-center">
            <div class="text-3xl font-bold"><?php echo $jumlah_praktikum; ?></div>
            <div>Praktikum Diikuti</div>
        </div>
        <div class="bg-green-100 p-4 rounded text-center">
            <div class="text-3xl font-bold"><?php echo $jumlah_laporan; ?></div>
            <div>Laporan Dikirim</div>
        </div>
        <div class="bg-yellow-100 p-4 rounded text-center">
            <div class="text-3xl font-bold"><?php echo $jumlah_dinilai; ?></div>
            <div>Laporan Dinilai</div>
        </div>
    </div>
    <h2 class="text-xl font-semibold mb-2">Praktikum Terakhir Diikuti</h2>
    <ul class="mb-4">
        <?php while($p = mysqli_fetch_assoc($praktikum_terakhir)): ?>
            <li class="mb-2">
                <span class="font-bold"><?php echo htmlspecialchars($p['nama_praktikum']); ?></span>
                <span class="text-gray-600">- <?php echo htmlspecialchars($p['deskripsi']); ?></span>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="praktikum_saya.php" class="bg-blue-500 text-white px-4 py-2 rounded">Lihat Praktikum Saya</a>
</div>
<?php include __DIR__.'/templates/footer_mahasiswa.php'; ?>