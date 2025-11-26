<?php
session_start();

// jika sudah login
if (isset($_SESSION['admin'])) {
    header("Location: /learnphp/admin/dashboard.php");
    exit;
}

// jika belum login arahkan ke halaman login
header("Location: /learnphp/admin/index.php");
exit;
?>
