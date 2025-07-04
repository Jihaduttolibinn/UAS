<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$allow_public = true;
include __DIR__.'/templates/header_mahasiswa.php';
include __DIR__.'/../config.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// Ambil data praktikum
$data = mysqli_query($conn, "SELECT * FROM praktikum ORDER BY nama_praktikum");

// Ambil daftar praktikum yang sudah didaftari user (jika mahasiswa)
$daftar_saya = [];
if ($user_id && $user_role == 'mahasiswa') {
    $q = mysqli_query($conn, "SELECT praktikum_id FROM pendaftaran WHERE user_id=$user_id");
    while($row = mysqli_fetch_assoc($q)) {
        $daftar_saya[] = $row['praktikum_id'];
    }
}
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Katalog Mata Praktikum</h1>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Nama Praktikum</th>
                <th class="border px-4 py-2">Deskripsi</th>
                <?php if ($user_role == 'mahasiswa'): ?><th class="border px-4 py-2">Aksi</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td class="border px-4 py-2"><?php echo $no++; ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['nama_praktikum']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                <?php if ($user_role == 'mahasiswa'): ?>
                <td class="border px-4 py-2">
                    <?php if (in_array($row['id'], $daftar_saya)): ?>
                        <span class="text-green-600 font-semibold">Sudah Terdaftar</span>
                    <?php else: ?>
                        <form method="post" action="daftar_praktikum.php" style="display:inline">
                            <input type="hidden" name="praktikum_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Daftar</button>
                        </form>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__.'/templates/footer_mahasiswa.php'; ?> 