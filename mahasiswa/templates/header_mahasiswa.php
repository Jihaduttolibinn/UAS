<?php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek jika pengguna belum login
if (!isset($allow_public) && !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Mahasiswa - <?php echo $pageTitle ?? 'Dashboard'; ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <span class="text-white text-2xl font-bold">SIMPRAK</span>
                    <div class="ml-10 flex items-baseline space-x-4">
                        <?php 
                            $activeClass = 'bg-blue-700 text-white';
                            $inactiveClass = 'text-gray-200 hover:bg-blue-700 hover:text-white';
                            $page = basename($_SERVER['PHP_SELF']);
                        ?>
                        <a href="/SistemPengumpulanTugas-main/mahasiswa/dashboard.php" class="<?php echo ($page == 'dashboard.php') ? $activeClass : $inactiveClass; ?> px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                        <a href="/SistemPengumpulanTugas-main/mahasiswa/katalog.php" class="<?php echo ($page == 'katalog.php') ? $activeClass : $inactiveClass; ?> px-3 py-2 rounded-md text-sm font-medium">Katalog Praktikum</a>
                        <a href="/SistemPengumpulanTugas-main/mahasiswa/praktikum_saya.php" class="<?php echo ($page == 'praktikum_saya.php') ? $activeClass : $inactiveClass; ?> px-3 py-2 rounded-md text-sm font-medium">Praktikum Saya</a>
                    </div>
                </div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div>
                        <a href="/SistemPengumpulanTugas-main/logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">Logout</a>
                    </div>
                <?php else: ?>
                    <div>
                        <a href="/SistemPengumpulanTugas-main/login.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300 mr-2">Login</a>
                        <a href="/SistemPengumpulanTugas-main/register.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors duration-300">Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6 lg:p-8">