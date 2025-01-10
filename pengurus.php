<?php
session_start();
include 'koneksi.php'; // Ensure your database connection is correct

// Adding student data
if (isset($_POST['add'])) {
    $nama = $_POST['Nama'];
    $jurusan = $_POST['Jurusan'];
    $divisi_bagian = $_POST['Divisi_Bagian'];
    $status = $_POST['Status'];

    try {
        $stmt = $pdo->prepare("INSERT INTO mahasiswa (Nama, Jurusan, Divisi_Bagian, Status) VALUES (:Nama, :Jurusan, :Divisi_Bagian, :Status)");
        $stmt->execute(['Nama' => $nama, 'Jurusan' => $jurusan, 'Divisi_Bagian' => $divisi_bagian, 'Status' => $status]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Deleting student data
if (isset($_GET['delete'])) {
    $nama = $_GET['delete'];

    try {
        $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE Nama = :Nama");
        $stmt->execute(['Nama' => $nama]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Displaying student data
try {
    $stmt = $pdo->query("SELECT * FROM mahasiswa");
    $mahasiswa = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Process updating data
if (isset($_POST['update'])) {
    $nama_baru = $_POST['Nama'];
    $jurusan = $_POST['Jurusan'];
    $divisi_bagian = $_POST['Divisi_Bagian'];
    $status = $_POST['Status'];
    $old_nama = $_POST['old_Nama']; // Get old name from the form

    try {
        $stmt = $pdo->prepare("UPDATE mahasiswa SET Nama = :Nama, Jurusan = :Jurusan, Divisi_Bagian = :Divisi_Bagian, Status = :Status WHERE Nama = :old_Nama");
        $stmt->execute(['Nama' => $nama_baru, 'Jurusan' => $jurusan, 'Divisi_Bagian' => $divisi_bagian, 'Status' => $status, 'old_Nama' => $old_nama]);
        header("Location: pengurus.php");
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
    <title>Data Pengurus 2024</title>
    <style>
        /* Styling untuk body */
        body {
            font-family: Arial, sans-serif;
            background-image: url('bg.jpg');
            margin: 0;
            padding: 20px;
        }

        /* Styling untuk judul */
        h2, h3 {
            text-align: center;
            color: #333;
        }

        /* Styling untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #ffcccc;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #ffe6e6;
        }

        tr:nth-child(odd) {
            background-color: #fff;
        }

        /* Styling untuk tombol */
        button, a {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            font-size: 14px;
            color: #fff;
            background-color: #ff6666;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        button:hover, a:hover {
            background-color: #ff4d4d;
        }

        /* Styling untuk form */
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        form button {
            background-color: #ff6666;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #ff4d4d;
        }

        .button-kembali {
        display: inline-block;
        padding: 8px 12px;
        margin-top: 20px;
        font-size: 14px;
        color: #fff;
        background-color:rgb(143, 50, 123);
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
    }

    .button-kembali:hover {
        background-color:rgb(206, 91, 149);
    }

    .tombol-kembali-container {
        display: flex;
        justify-content: center; /* Menyusun tombol secara horizontal di tengah */
        align-items: center; /* Menyusun tombol secara vertikal di tengah */
        height: 100vh; /* Menyediakan ruang vertikal penuh */
    }
    </style>
</head>
<body>
<h2>Data Pengurus 2024</h2>

<!-- Displaying the student data table -->
<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Divisi / Bagian</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mahasiswa as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['Nama']) ?></td>
                <td><?= htmlspecialchars($row['Jurusan']) ?></td>
                <td><?= htmlspecialchars($row['Divisi_Bagian']) ?></td>
                <td><?= htmlspecialchars($row['Status']) ?></td>
                <td>
                    <!-- Edit button -->
                    <button type="button" onclick="editMahasiswa({
                        Nama: '<?= htmlspecialchars($row['Nama']) ?>',
                        Jurusan: '<?= htmlspecialchars($row['Jurusan']) ?>',
                        Divisi_Bagian: '<?= htmlspecialchars($row['Divisi_Bagian']) ?>',
                        Status: '<?= htmlspecialchars($row['Status']) ?>'
                    })">Edit</button>

                    <!-- Delete button -->
                    <a href="pengurus.php?delete=<?= htmlspecialchars($row['Nama']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Tambah / Edit Data Pengurus</h3>
<form id="form-mahasiswa" action="pengurus.php" method="POST">
    <input type="hidden" id="old_Nama" name="old_Nama"> <!-- Hidden input for old name -->
    <label for="Nama">Nama:</label>
    <input type="text" id="Nama" name="Nama" required>
    
    <label for="Jurusan">Jurusan:</label>
    <input type="text" id="Jurusan" name="Jurusan" required>
    
    <label for="Divisi_Bagian">Divisi / Bagian:</label>
    <input type="text" id="Divisi_Bagian" name="Divisi_Bagian" required>
    
    <label for="Status">Status:</label>
    <select id="Status" name="Status" required>
        <option value="aktif">Aktif</option>
        <option value="tidak aktif">Tidak Aktif</option>
    </select>

    <button type="submit" name="add">Tambah</button>
    <button type="submit" name="update">Update</button> <!-- Update button -->
</form>

<script>
    // Function to scroll to the form
    function scrollToForm() {
        document.getElementById('form-mahasiswa').scrollIntoView({ behavior: 'smooth' });
    }

    // Function to fill the form with data to be edited
    function editMahasiswa(data) {
        document.getElementById('Nama').value = data.Nama;
        document.getElementById('Jurusan').value = data.Jurusan;
        document.getElementById('Divisi_Bagian').value = data.Divisi_Bagian;
        document.getElementById('Status').value = data.Status;
        document.getElementById('old_Nama').value = data.Nama; // Set old name

        // Scroll to the form
        scrollToForm();
    }
</script>

<a href="menu.php" class="button-kembali">Kembali ke Menu</a>
</body>
</html>