<?php
// Koneksi database
$host = "localhost";
$user = "root";
$password = "";
$database = "ukm_system";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data agenda dari database
$sql = "SELECT * FROM agenda";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}


session_start();

$nama = isset($_SESSION['Nama_Lengkap']) ? $_SESSION['Nama_Lengkap'] : 'Nama Tidak Tersedia';
$jurusan = isset($_SESSION['Jurusan']) ? $_SESSION['Jurusan'] : 'Jurusan Tidak Tersedia';
$divisi = isset($_SESSION['Divisi_Bagian']) ? $_SESSION['Divisi_Bagian'] : 'Divisi Tidak Tersedia';
$status = isset($_SESSION['Status']) ? $_SESSION['Status'] : 'Status Tidak Tersedia';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Tombol Data Pengurus -->
        <div class="menu-item">
            <a href="pengurus.php">
                <img src="organisasi.png" alt="Data Pengurus">
                <p>Data Pengurus</p>
            </a>
        </div>

        <!-- Tombol Kehadiran Rapat -->
        <div class="menu-item">
            <a href="rapat.php">
                <img src="laporan.png" alt="Kehadiran Rapat">
                <p>Kehadiran Rapat atau Kegiatan</p>
            </a>
        </div>

        <!-- Tombol Logout -->
        <div class="menu-logout logout-item">
            <p><img src="logout.png" alt="Logout"></p>
            <a href="login.php">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
<div class="main-content">
    <div class="profile">
        <img src="GambarProfil.png" alt="Avatar" class="avatar">
        <div class="text">
        <p><div><?php echo htmlspecialchars($nama); ?></div></p>
        <p><div><?php echo htmlspecialchars($jurusan); ?></div></p>
        <p><div><?php echo htmlspecialchars($divisi); ?></div></p>
        <p><div><?php echo htmlspecialchars($status); ?></div></p>
    </div>
    </div>
</div>

<div class="edit">
    <a href="editprof.php">
        <img src="edittt.png" alt="Edit Profil">
    </a>
</div>

    <!-- Tombol Pengumuman -->
    <div class="announcement-container">
        <button class="announcement-button" onclick="toggleAnnouncementInfo()">Pengumuman</button>
    </div>

<!-- Modal untuk Pengumuman -->
<div id="meetingInfoBar" class="modal">
    <div class="modal-content">
        <h3>Pengumuman Agenda</h3>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="meeting-card">
                    <h4><?php echo htmlspecialchars($row['agenda']); ?></h4>
                    <p><strong>Tanggal:</strong> <?php echo htmlspecialchars($row['tanggal']); ?></p>
                    <p><strong>Waktu:</strong> <?php echo htmlspecialchars($row['pukul']); ?></p>
                    <p><strong>Tempat:</strong> <?php echo htmlspecialchars($row['tempat']); ?></p>
                    <!-- Tombol Edit -->
                    <div class="buttons">
                        <a href="agenda.php?edit=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada pengumuman agenda yang tersedia.</p>
        <?php endif; ?>
        <button class="btn close-modal" onclick="toggleAnnouncementInfo()">Tutup</button>
    </div>
</div>

    <script>
        function toggleAnnouncementInfo() {
            var modal = document.getElementById('meetingInfoBar');
            if (modal.style.display === "block") {
                modal.style.display = "none";
            } else {
                modal.style.display = "block";
            }
        }

        // Tutup modal jika pengguna mengklik di luar modal
        window.onclick = function(event) {
            var modal = document.getElementById('meetingInfoBar');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
