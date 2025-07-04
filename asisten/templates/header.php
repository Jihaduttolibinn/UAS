<?php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek jika pengguna belum login atau bukan asisten
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'asisten') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Asisten - <?php echo $pageTitle ?? 'Dashboard'; ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100">

<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 h-screen bg-gray-800 text-white fixed">
        <div class="p-6 font-bold text-xl border-b border-gray-700">
            Panel Asisten
            <div class="text-sm font-normal text-gray-300">Naldi</div>
        </div>
        <nav class="mt-6">
            <a href="/SistemPengumpulanTugas-main/asisten/dashboard.php" class="block px-6 py-3 hover:bg-gray-700 <?php if(basename($_SERVER['PHP_SELF'])=='dashboard.php') echo 'bg-gray-900'; ?>">
                <span class="mr-2">🏠</span> Dashboard
            </a>
            <a href="/SistemPengumpulanTugas-main/asisten/praktikum/index.php" class="block px-6 py-3 hover:bg-gray-700 <?php if(strpos($_SERVER['PHP_SELF'],'praktikum')!==false) echo 'bg-gray-900'; ?>">
                <span class="mr-2">📚</span> Kelola Praktikum
            </a>
            <a href="/SistemPengumpulanTugas-main/asisten/modul/index.php" class="block px-6 py-3 hover:bg-gray-700 <?php if(strpos($_SERVER['PHP_SELF'],'modul')!==false) echo 'bg-gray-900'; ?>">
                <span class="mr-2">🗂️</span> Kelola Modul
            </a>
            <a href="/SistemPengumpulanTugas-main/asisten/laporan/index.php" class="block px-6 py-3 hover:bg-gray-700 <?php if(strpos($_SERVER['PHP_SELF'],'laporan')!==false) echo 'bg-gray-900'; ?>">
                <span class="mr-2">📝</span> Laporan Masuk
            </a>
            <a href="/SistemPengumpulanTugas-main/asisten/akun/index.php" class="block px-6 py-3 hover:bg-gray-700 <?php if(strpos($_SERVER['PHP_SELF'],'akun')!==false) echo 'bg-gray-900'; ?>">
                <span class="mr-2">👤</span> Kelola Akun Pengguna
            </a>
        </nav>
    </div>

    <main class="flex-1 p-6 lg:p-10">
        <header class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800"><?php echo $pageTitle ?? 'Dashboard'; ?></h1>
            <a href="/SistemPengumpulanTugas-main/logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                Logout
            </a>
        </header>