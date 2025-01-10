<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'koneksi.php'; // Ganti dengan koneksi database Anda

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Enkripsi password

    try {
        // Simpan data ke tabel users
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ]);

        // Redirect ke halaman login setelah berhasil registrasi
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="login.css"> <!-- Gunakan CSS Anda -->
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="logo.png" alt="Logo Buku">
        </div>
        <form class="login-form" method="POST" action="">
            <p><input type="text" name="username" placeholder="USERNAME" required></p>
            <p><input type="email" name="email" placeholder="EMAIL" required></p>
            <p><input type="password" name="password" placeholder="PASSWORD" required></p>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <p><button type="submit" class="btn">BUAT AKUN</button></p>
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </form>
    </div>
</body>
</html>
