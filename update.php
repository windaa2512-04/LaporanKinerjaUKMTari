<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi database Anda sudah benar

if (isset($_GET['Nama'])) {
    $nama = $_GET['Nama'];

    // Ambil data mahasiswa berdasarkan Nama
    $stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE Nama = :Nama");
    $stmt->execute(['Nama' => $nama]);
    $row = $stmt->fetch();

    if (!$row) {
        die("Data tidak ditemukan");
    }

    // Proses update data
    if (isset($_POST['update'])) {
        $nama_baru = $_POST['Nama'];
        $jurusan = $_POST['Jurusan'];
        $divisi_bagian = $_POST['Divisi_Bagian'];
        $status = $_POST['Status'];

        $stmt = $pdo->prepare("UPDATE mahasiswa SET Nama = :Nama, Jurusan = :Jurusan, Divisi_Bagian = :Divisi_Bagian, Status = :Status WHERE Nama = :old_Nama");
        $stmt->execute(['Nama' => $nama_baru, 'Jurusan' => $jurusan, 'Divisi_Bagian' => $divisi_bagian, 'Status' => $status, 'old_Nama' => $nama]);

        echo "Data berhasil diperbarui!";
        header("Location: pengurus.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Mahasiswa</title>
</head>
<body>
    <h3>Update Data Mahasiswa</h3>
    <form action="update.php?Nama=<?= htmlspecialchars($row['Nama']) ?>" method="POST">
        <label for="Nama">Nama:</label>
        <input type="text" id="Nama" name="Nama" value="<?= htmlspecialchars($row['Nama']) ?>" required><br><br>

        <label for="Jurusan">Jurusan:</label>
        <input type="text" id="Jurusan" name="Jurusan" value="<?= htmlspecialchars($row['Jurusan']) ?>" required><br><br>

        <label for="Divisi_Bagian">Divisi / Bagian:</label>
        <input type="text" id="Divisi_Bagian" name="Divisi_Bagian" value="<?= htmlspecialchars($row['Divisi_Bagian']) ?>" required><br><br>

        <label for="Status">Status:</label>
        <select name="Status" required>
            <option value="aktif" <?= $row['Status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="tidak aktif" <?= $row['Status'] == 'tidak aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
        </select><br><br>

        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
