<?php
// edit_profil.php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['Nama_Lengkap'] = $_POST['nama'];
    $_SESSION['Jurusan'] = $_POST['jurusan'];
    $_SESSION['Divisi_Bagian'] = $_POST['divisi'];
    $_SESSION['Status'] = $_POST['status'];

    header("Location: menu.php");
    exit();
}

$nama = isset($_SESSION['Nama_Lengkap']) ? $_SESSION['Nama_Lengkap'] : '';
$jurusan = isset($_SESSION['Jurusan']) ? $_SESSION['Jurusan'] : '';
$divisi = isset($_SESSION['Divisi_Bagian']) ? $_SESSION['Divisi_Bagian'] : '';
$status = isset($_SESSION['Status']) ? $_SESSION['Status'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <div class="container">
        <h2>Edit Profil</h2>
        <form method="POST" action="">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>

            <label for="jurusan">Jurusan:</label>
            <input type="text" id="jurusan" name="jurusan" value="<?php echo htmlspecialchars($jurusan); ?>" required>

            <label for="divisi">Divisi Bagian:</label>
            <input type="text" id="divisi" name="divisi" value="<?php echo htmlspecialchars($divisi); ?>" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="aktif" <?php echo $status === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="tidak aktif" <?php echo $status === 'tidak aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
