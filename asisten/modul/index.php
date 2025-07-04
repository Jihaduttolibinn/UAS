<?php
include __DIR__.'/../templates/header.php';
include __DIR__.'/../../config.php';

if (!isset($_GET['id_praktikum'])) {
    echo '<div class="container mx-auto p-4">'
        .'<div class="bg-yellow-100 text-yellow-800 p-2 mb-2">Pilih praktikum terlebih dahulu.</div>'
        .'<a href="../praktikum/index.php" class="text-blue-600 underline">Kembali ke Daftar Praktikum</a>'
        .'</div>';
    include __DIR__.'/../templates/footer.php';
    exit;
}
$id_praktikum = intval($_GET['id_praktikum']);

// Ambil data praktikum
$praktikum = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM praktikum WHERE id=$id_praktikum"));
if (!$praktikum) {
    echo '<div class="p-4">Data praktikum tidak ditemukan.</div>';
    include __DIR__.'/../templates/footer.php';
    exit;
}

// Ambil data modul
$data = mysqli_query($conn, "SELECT * FROM modul WHERE praktikum_id=$id_praktikum ORDER BY id ASC");
?>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Modul Praktikum: <?php echo htmlspecialchars($praktikum['nama_praktikum']); ?></h1>
        <a href="tambah.php?id_praktikum=<?php echo $id_praktikum; ?>" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Modul</a>
        <a href="../praktikum/index.php" class="ml-2 text-gray-600">Kembali ke Daftar Praktikum</a>
        <table class="min-w-full bg-white border mt-4">
            <thead>
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Judul Modul</th>
                    <th class="border px-4 py-2">File Materi</th>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo $no++; ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($row['judul_modul']); ?></td>
                    <td class="border px-4 py-2">
                        <?php if ($row['file_materi']): ?>
                            <a href="../../uploads/materi/<?php echo htmlspecialchars($row['file_materi']); ?>" target="_blank" class="text-blue-600 underline">Download</a>
                        <?php else: ?>
                            <span class="text-gray-400">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($row['tanggal']); ?></td>
                    <td class="border px-4 py-2">
                        <a href="edit.php?id=<?php echo $row['id']; ?>&id_praktikum=<?php echo $id_praktikum; ?>" class="bg-yellow-400 px-2 py-1 rounded">Edit</a>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>&id_praktikum=<?php echo $id_praktikum; ?>" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include __DIR__.'/../templates/footer.php'; ?> 