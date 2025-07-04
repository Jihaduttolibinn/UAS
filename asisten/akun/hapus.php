<?php
include '../../config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);

// Hapus user
$delete = mysqli_query($conn, "DELETE FROM users WHERE id=$id");
header('Location: index.php');
exit; 