<?php
include '../templates/header.php';
include '../../config.php';

// Ambil data filter
$praktikum_id = isset($_GET['praktikum_id']) ? intval($_GET['praktikum_id']) : '';
$modul_id = isset($_GET['modul_id']) ? intval($_GET['modul_id']) : '';
$mahasiswa_id = isset($_GET['mahasiswa_id']) ? intval($_GET['mahasiswa_id']) : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Ambil data praktikum
$praktikum_list = mysqli_query($conn, "SELECT * FROM praktikum ORDER BY nama_praktikum");
// Ambil data mahasiswa
$mahasiswa_list = mysqli_query($conn, "SELECT * FROM users WHERE role='mahasiswa' ORDER BY nama");
// Ambil data modul (jika praktikum dipilih)
$modul_list = $praktikum_id ? mysqli_query($conn, "SELECT * FROM modul WHERE praktikum_id=$praktikum_id ORDER BY judul_modul") : false;

// Query laporan
$q = "SELECT laporan.*, users.nama AS nama_mahasiswa, modul.judul_modul, praktikum.nama_praktikum
      FROM laporan
      JOIN users ON laporan.user_id = users.id
      JOIN modul ON laporan.modul_id = modul.id
      JOIN praktikum ON modul.praktikum_id = praktikum.id
      WHERE 1";
if ($praktikum_id) $q .= " AND praktikum.id = $praktikum_id";
if ($modul_id) $q .= " AND modul.id = $modul_id";
if ($mahasiswa_id) $q .= " AND users.id = $mahasiswa_id";
if ($status) $q .= " AND laporan.status = '".mysqli_real_escape_string($conn, $status)."'";
$q .= " ORDER BY laporan.tanggal_upload DESC";
$data = mysqli_query($conn, $q);
?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Laporan Masuk</h1>
    <form method="get" class="mb-4 flex flex-wrap gap-2 items-end">
        <div>
            <label class="block mb-1">Praktikum</label>
            <select name="praktikum_id" class="border p-2">
                <option value="">Semua</option>
                <?php while($p = mysqli_fetch_assoc($praktikum_list)): ?>
                    <option value="<?php echo $p['id']; ?>" <?php if($praktikum_id==$p['id']) echo 'selected'; ?>><?php echo htmlspecialchars($p['nama_praktikum']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Modul</label>
            <select name="modul_id" class="border p-2">
                <option value="">Semua</option>
                <?php if($modul_list) while($m = mysqli_fetch_assoc($modul_list)): ?>
                    <option value="<?php echo $m['id']; ?>" <?php if($modul_id==$m['id']) echo 'selected'; ?>><?php echo htmlspecialchars($m['judul_modul']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Mahasiswa</label>
            <select name="mahasiswa_id" class="border p-2">
                <option value="">Semua</option>
                <?php while($mhs = mysqli_fetch_assoc($mahasiswa_list)): ?>
                    <option value="<?php echo $mhs['id']; ?>" <?php if($mahasiswa_id==$mhs['id']) echo 'selected'; ?>><?php echo htmlspecialchars($mhs['nama']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Status</label>
            <select name="status" class="border p-2">
                <option value="">Semua</option>
                <option value="dikirim" <?php if($status=='dikirim') echo 'selected'; ?>>Dikirim</option>
                <option value="dinilai" <?php if($status=='dinilai') echo 'selected'; ?>>Dinilai</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
    </form>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Mahasiswa</th>
                <th class="border px-4 py-2">Praktikum</th>
                <th class="border px-4 py-2">Modul</th>
                <th class="border px-4 py-2">Tanggal Upload</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Nilai</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td class="border px-4 py-2"><?php echo $no++; ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['nama_praktikum']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['judul_modul']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['tanggal_upload']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['status']); ?></td>
                <td class="border px-4 py-2"><?php echo is_null($row['nilai']) ? '-' : htmlspecialchars($row['nilai']); ?></td>
                <td class="border px-4 py-2">
                    <a href="detail.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-2 py-1 rounded">Detail</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../templates/footer.php'; ?> 