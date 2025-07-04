<?php
include '../templates/header.php';
include '../../config.php';

// Ambil data user
$data = mysqli_query($conn, "SELECT * FROM users ORDER BY role, nama");
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Akun Pengguna</h1>
    <a href="tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah User</a>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Role</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td class="border px-4 py-2"><?php echo $no++; ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['nama']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['email']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['role']); ?></td>
                <td class="border px-4 py-2">
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="bg-yellow-400 px-2 py-1 rounded">Edit</a>
                    <a href="hapus.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../templates/footer.php'; ?> 