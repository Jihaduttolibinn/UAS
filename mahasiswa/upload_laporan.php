<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: ../login.php');
    exit;
}
include __DIR__.'/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modul_id']) && isset($_FILES['file_laporan'])) {
    $user_id = intval($_SESSION['user_id']);
    $modul_id = intval($_POST['modul_id']);
    // Cek praktikum id untuk redirect
    $modul = mysqli_fetch_assoc(mysqli_query($conn, "SELECT praktikum_id FROM modul WHERE id=$modul_id"));
    $praktikum_id = $modul ? $modul['praktikum_id'] : 0;
    $ext = pathinfo($_FILES['file_laporan']['name'], PATHINFO_EXTENSION);
    $nama_file = 'laporan_'.$user_id.'_'.$modul_id.'_'.time().'.'.$ext;
    $tujuan = __DIR__.'/../uploads/laporan/'.$nama_file;
    if (move_uploaded_file($_FILES['file_laporan']['tmp_name'], $tujuan)) {
        // Cek sudah pernah upload
        $cek = mysqli_query($conn, "SELECT id FROM laporan WHERE user_id=$user_id AND modul_id=$modul_id");
        if (mysqli_num_rows($cek) == 0) {
            mysqli_query($conn, "INSERT INTO laporan (user_id, modul_id, file_laporan) VALUES ($user_id, $modul_id, '$nama_file')");
        } else {
            mysqli_query($conn, "UPDATE laporan SET file_laporan='$nama_file', status='dikirim', nilai=NULL, feedback=NULL, tanggal_upload=NOW() WHERE user_id=$user_id AND modul_id=$modul_id");
        }
    }
    header('Location: detail_praktikum.php?id='.$praktikum_id);
    exit;
}
header('Location: praktikum_saya.php');
exit; 