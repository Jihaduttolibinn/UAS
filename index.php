<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'mahasiswa') {
        header('Location: mahasiswa/dashboard.php');
        exit;
    } elseif ($_SESSION['role'] == 'asisten') {
        header('Location: asisten/dashboard.php');
        exit;
    }
}
// Jika belum login, tampilkan katalog dan tombol login/register
include 'mahasiswa/katalog.php';
echo '<div class="container mx-auto p-4 text-center">';
echo '<a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Login</a>';
echo '<a href="register.php" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Register</a>';
echo '</div>'; 