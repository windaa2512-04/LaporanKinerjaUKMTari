<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi database Anda sudah benar

// Menambah data rapat
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $kegiatan = $_POST['kegiatan'];
    $keterangan = $_POST['keterangan'];

    try {
        $stmt = $pdo->prepare("INSERT INTO rapat (name, kegiatan, keterangan) VALUES (:name, :kegiatan, :keterangan)");
        $stmt->execute(['name' => $name, 'kegiatan' => $kegiatan, 'keterangan' => $keterangan]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Menghapus data rapat
if (isset($_GET['delete'])) {
    $name = $_GET['delete'];

    try {
        $stmt = $pdo->prepare("DELETE FROM rapat WHERE name = :name");
        $stmt->execute(['name' => $name]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Menampilkan data rapat
try {
    $stmt = $pdo->query("SELECT * FROM rapat");
    $rapat = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Proses update data
if (isset($_POST['update'])) {
    $nama_baru = $_POST['name'];
    $kegiatan = $_POST['kegiatan'];
    $keterangan = $_POST['keterangan'];
    $old_name = $_POST['old_name']; // Ambil nama lama dari form

    try {
        $stmt = $pdo->prepare("UPDATE rapat SET name = :name, kegiatan = :kegiatan, keterangan = :keterangan WHERE name = :old_name");
        $stmt->execute(['name' => $nama_baru, 'kegiatan' => $kegiatan, 'keterangan' => $keterangan, 'old_name' => $old_name]);
        header("Location: rapat.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran Rapat atau Kegiatan</title>
    <link rel="stylesheet" href="rapat.css">
</head>
<body>
<h2>Kehadiran Rapat atau Kegiatan</h2>

<!-- Menampilkan tabel data rapat -->
<table>
    <thead>
        <tr>
            <th>Nama Lengkap</th>
            <th>Kegiatan</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rapat as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['kegiatan']) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td>
                    <!-- Tombol Edit -->
                    <button type="button" onclick="editrapat({
                        name: '<?= htmlspecialchars($row['name']) ?>',
                        kegiatan: '<?= htmlspecialchars($row['kegiatan']) ?>',
                        keterangan: '<?= htmlspecialchars($row['keterangan']) ?>',
                    })">Edit</button>

                    <!-- Tombol Hapus -->
                    <a href="rapat.php?delete=<?= htmlspecialchars($row['name']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Tambah / Edit Data Rapat</h3>
<form id="form-rapat" action="rapat.php" method="POST">
    <input type="hidden" id="old_name" name="old_name"> <!-- Hidden input untuk nama lama -->
    <label for="name">Nama Lengkap:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="kegiatan">Kegiatan:</label>
    <input type="text" id="kegiatan" name="kegiatan" required>
    
    <label for="keterangan">Keterangan:</label>
    <select id="keterangan" name="keterangan" required>
        <option value="hadir">Hadir</option>
        <option value="tidak hadir">Tidak Hadir</option>
    </select>

    <button type="submit" name="add">Tambah</button>
    <button type="submit" name="update">Update</button> <!-- Tombol untuk update -->
</form>

<script>
    // Fungsi untuk menggulir ke form
    function scrollToForm() {
        document.getElementById('form-rapat').scrollIntoView({ behavior: 'smooth' });
    }

    // Fungsi untuk mengisi form dengan data yang akan diedit
    function editrapat(data) {
        // Mengisi input form dengan data yang diterima
        document.getElementById('name').value = data.name;
        document.getElementById('kegiatan').value = data.kegiatan;
        document.getElementById('keterangan').value = data.keterangan;
        document.getElementById('old_name').value = data.name; // Set nama lama

        // Menggulung ke form
        scrollToForm();
    }
</script>

<a href="menu.php" class="button-kembali">Kembali ke Menu</a>
</body>
</html>