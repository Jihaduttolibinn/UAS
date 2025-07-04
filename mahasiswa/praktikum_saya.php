<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: ../login.php');
    exit;
}
include __DIR__.'/templates/header_mahasiswa.php';
include __DIR__.'/../config.php';

$user_id = intval($_SESSION['user_id']);
$data = mysqli_query($conn, "SELECT p.id, p.nama_praktikum, p.deskripsi FROM praktikum p JOIN pendaftaran d ON p.id = d.praktikum_id WHERE d.user_id = $user_id");
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Praktikum Saya</h1>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Nama Praktikum</th>
                <th class="border px-4 py-2">Deskripsi</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td class="border px-4 py-2"><?php echo $no++; ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['nama_praktikum']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                <td class="border px-4 py-2">
                    <a href="detail_praktikum.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-2 py-1 rounded">Detail</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__.'/templates/footer_mahasiswa.php'; ?> 