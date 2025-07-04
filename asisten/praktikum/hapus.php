<?php
include '../../config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);

// Hapus data
mysqli_query($conn, "DELETE FROM praktikum WHERE id=$id");
header('Location: index.php');
exit; 