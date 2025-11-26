<?php
session_start();
include "../main/connect.php";

$username = $_POST['username'];
$nama     = $_POST['nama'];
$password = sha1($_POST['password']);

$insert = mysqli_query($conn, "INSERT INTO admin (adminUsername, adminName, adminPassword, adminStatus, adminLastLogin) 
VALUES ('$username', '$nama', '$password', 'active', 0)");

if ($insert) {
    $_SESSION['success'] = "Admin berhasil ditambahkan!";
} else {
    $_SESSION['error'] = "Gagal menambah admin!";
}

header("Location: admin.php");
exit;
?>
