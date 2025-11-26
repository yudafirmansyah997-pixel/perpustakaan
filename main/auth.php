<?php
session_start();
include "connect.php";

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $_SESSION['error'] = "Isi username & password terlebih dahulu!";
    header("Location: ../admin/index.php");
    exit;
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = sha1($_POST['password']);

$query = mysqli_query($conn, "SELECT * FROM admin WHERE adminUsername='$username'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    if ($data['adminPassword'] === $password) {

        if ($data['adminStatus'] != 'active') {
            $_SESSION['error'] = "Akun ini sedang dinonaktifkan!";
            header("Location: ../admin/index.php");
            exit;
        }

        // UPDATE WAKTU LOGIN
        $id = $data['adminId'];
        mysqli_query($conn, "UPDATE admin SET adminLastLogin = UNIX_TIMESTAMP() WHERE adminId = $id");

        // SIMPAN SESSION
        $_SESSION['admin'] = true;
        $_SESSION['adminId'] = $data['adminId'];
        $_SESSION['adminName'] = $data['adminName'];

        header("Location: ../admin/dashboard.php");
        exit;
    }
}

$_SESSION['error'] = "Username atau password salah!";
header("Location: ../admin/index.php");
exit;
?>
