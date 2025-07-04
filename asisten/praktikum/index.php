<?php
include __DIR__.'/../templates/header.php';
include __DIR__.'/../../config.php';

// Ambil data praktikum
$data = mysqli_query($conn, "SELECT * FROM praktikum ORDER BY id DESC");
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Mata Praktikum</h1>
    <a href="tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Praktikum</a>
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
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="bg-yellow-400 px-2 py-1 rounded">Edit</a>
                    <a href="hapus.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    <a href="../modul/index.php?id_praktikum=<?php echo $row['id']; ?>" class="bg-green-500 text-white px-2 py-1 rounded ml-2">Kelola Modul</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__.'/../templates/footer.php'; ?> 