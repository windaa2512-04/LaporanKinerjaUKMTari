<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background-image: url('bg.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Kontainer utama */
.container {
    text-align: center;
}

/* Bagian Selamat Datang */
.welcome {
    display: flex;
    align-items: center;
    justify-content: start;
    font-size: 1.2em;
    color: #b34d4d;
    margin-bottom: 20px;
}

.avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

/* Bagian Logo */
.logo img {
    width: 220px;
    margin-bottom: 10px;
}

.logo h2 {
    font-size: 2em;
    font-weight: bold;
    color: #ff4f8c;
}

.logo h3 {
    font-size: 1.2em;
    color: #ff6fa5;
}

/* Tombol */
.button-container {
    margin-top: 20px;
}

button {
    background-color: #ff6fa5;
    border: none;
    color: white;
    padding: 15px 30px;
    font-size: 1.2em;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s ease;
}

button:hover {
    background-color: #ff4f8c;
    transform: scale(1.05);
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Bagian Selamat Datang -->
        <div class="welcome">
            <img src="GambarProfil.png" alt="Avatar" class="avatar">
            <span>Selamat Datang, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>.</span>
        </div>

        <!-- Bagian Logo -->
        <div class="logo">
            <img src="LOGO.png" alt="Logo Buku">
        </div>

        <!-- Tombol -->
        <div class="button-container">
        <button id="checkNow">CHECK NOW!</button>

<script>
    document.getElementById('checkNow').addEventListener('click', function () {
        window.location.href = 'menu.php';
    });
</script>

        </div>
    </div>
</body>
</html>
