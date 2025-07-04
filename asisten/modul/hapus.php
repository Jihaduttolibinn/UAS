<?php
include '../../config.php';

if (!isset($_GET['id']) || !isset($_GET['id_praktikum'])) {
    header('Location: ../praktikum/index.php');
    exit;
}
$id = intval($_GET['id']);
$id_praktikum = intval($_GET['id_praktikum']);

// Ambil data file materi
$q = mysqli_query($conn, "SELECT file_materi FROM modul WHERE id=$id AND praktikum_id=$id_praktikum");
$row = mysqli_fetch_assoc($q);
if ($row && $row['file_materi'] && file_exists('../../uploads/materi/'.$row['file_materi'])) {
    unlink('../../uploads/materi/'.$row['file_materi']);
}

// Hapus data modul
$del = mysqli_query($conn, "DELETE FROM modul WHERE id=$id AND praktikum_id=$id_praktikum");
header('Location: index.php?id_praktikum='.$id_praktikum);
exit; 