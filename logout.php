<?php
// Mulai sesi
session_start();

// Hapus semua data sesi
$_SESSION = [];

// Hancurkan sesi
session_destroy();

// Hapus cookie sesi (opsional, jika Anda menggunakan cookie sesi)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect ke halaman login atau halaman lain
header("Location: login.php");
exit;
?>
