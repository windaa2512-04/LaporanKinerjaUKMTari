<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "ukm_system";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk menambahkan data
if (isset($_POST['add'])) {
    $agenda = $_POST['agenda'];
    $tanggal = $_POST['tanggal'];
    $pukul = $_POST['pukul'];
    $tempat = $_POST['tempat'];

    $sql = "INSERT INTO agenda (agenda, tanggal, pukul, tempat) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $agenda, $tanggal, $pukul, $tempat);
    $stmt->execute();
}

// Fungsi untuk menghapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM agenda WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Fungsi untuk mengedit data
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $agenda = $_POST['agenda'];
    $tanggal = $_POST['tanggal'];
    $pukul = $_POST['pukul'];
    $tempat = $_POST['tempat'];

    $sql = "UPDATE agenda SET agenda = ?, tanggal = ?, pukul = ?, tempat = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $agenda, $tanggal, $pukul, $tempat, $id);
    $stmt->execute();
}

// Ambil semua data
$result = $conn->query("SELECT * FROM agenda ORDER BY tanggal ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link rel="stylesheet" href="agenda.css">
</head>
<body>
    <div class="container">
        <h1>Agenda</h1>
        <div style="margin-bottom: 20px;">
            <a href="menu.php" class="btn back">Kembali ke Menu</a>
        </div>
        <form method="POST" action="">
            <input type="text" name="agenda" id="agenda" placeholder="Agenda" required>
            <input type="date" name="tanggal" id="tanggal" required>
            <input type="time" name="pukul" id="pukul" required>
            <input type="text" name="tempat" id="tempat" placeholder="Tempat" required>
            <button type="submit" name="add">Tambah</button>
            <button type="submit" name="edit">Simpan</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Agenda</th>
                    <th>Tanggal</th>
                    <th>Pukul</th>
                    <th>Tempat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['agenda']; ?></td>
                        <td><?php echo $row['tanggal']; ?></td>
                        <td><?php echo $row['pukul']; ?></td>
                        <td><?php echo $row['tempat']; ?></td>
                        <td>
                        <a class="btn delete" href="?delete=<?php echo $row['id']; ?>">Hapus</a>
                        <button class="btn edit" onclick="editData(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editData(row) {
            document.getElementById('agenda').value = row.agenda;
            document.getElementById('tanggal').value = row.tanggal;
            document.getElementById('pukul').value = row.pukul;
            document.getElementById('tempat').value = row.tempat;
        }
    </script>
</body>
</html>
