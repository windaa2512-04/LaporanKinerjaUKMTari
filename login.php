<?php
session_start(); // Memulai sesi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'koneksi.php'; // Ganti dengan koneksi database Anda

    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Ambil data pengguna berdasarkan email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        // Verifikasi password
        if ($user && password_verify($password, $user['password'])) {
            // Set sesi setelah login berhasil
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Redirect ke halaman dashboard
            header("Location: beranda.php");
            exit();
        } else {
            $error = "Email atau password salah!";
        }
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
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Gunakan CSS Anda -->
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="logo.png" alt="Logo Buku">
        </div>
        <form class="login-form" method="POST" action="">
            <p><input type="email" name="email" placeholder="EMAIL" required></p>
            <p><input type="password" name="password" placeholder="PASSWORD" required></p>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <p><button type="submit" class="btn">MASUK</button></p>
            <p>Belum punya akun? <a href="buatakun.php">Daftar di sini</a></p>
        </form>
    </div>
</body>
</html>
