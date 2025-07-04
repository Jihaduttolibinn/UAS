<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: ../login.php');
    exit;
}
include __DIR__.'/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['praktikum_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $praktikum_id = intval($_POST['praktikum_id']);
    // Cek sudah daftar atau belum
    $cek = mysqli_query($conn, "SELECT id FROM pendaftaran WHERE user_id=$user_id AND praktikum_id=$praktikum_id");
    if (mysqli_num_rows($cek) == 0) {
        $q = mysqli_query($conn, "INSERT INTO pendaftaran (user_id, praktikum_id) VALUES ($user_id, $praktikum_id)");
        $_SESSION['pesan'] = $q ? 'Berhasil mendaftar praktikum.' : 'Gagal mendaftar praktikum.';
    } else {
        $_SESSION['pesan'] = 'Anda sudah terdaftar di praktikum ini.';
    }
}
header('Location: katalog.php');
exit; 