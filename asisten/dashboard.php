<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'asisten') {
    header('Location: ../login.php');
    exit;
}
include __DIR__.'/templates/header.php';
include __DIR__.'/../config.php';

// Query ringkasan data
$jumlah_praktikum = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM praktikum"))[0];
$jumlah_modul = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM modul"))[0];
$jumlah_laporan = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM laporan"))[0];
$jumlah_user = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users"))[0];
?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard Asisten</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-100 p-4 rounded text-center">
            <div class="text-3xl font-bold"><?php echo $jumlah_praktikum; ?></div>
            <div>Mata Praktikum</div>
        </div>
        <div class="bg-green-100 p-4 rounded text-center">
            <div class="text-3xl font-bold"><?php echo $jumlah_modul; ?></div>
            <div>Modul</div>
        </div>
        <div class="bg-yellow-100 p-4 rounded text-center">
            <div class="text-3xl font-bold"><?php echo $jumlah_laporan; ?></div>
            <div>Laporan Masuk</div>
        </div>
        <div class="bg-purple-100 p-4 rounded text-center">
            <div class="text-3xl font-bold"><?php echo $jumlah_user; ?></div>
            <div>User</div>
        </div>
    </div>
</div>
<?php include __DIR__.'/templates/footer.php'; ?>