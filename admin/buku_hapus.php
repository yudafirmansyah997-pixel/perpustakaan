<?php
include "../main/connect.php";
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$id = $_POST['id'];

$sql = mysqli_query($conn, "DELETE FROM buku WHERE bukuId='$id'");

if ($sql) {
    $_SESSION['alert'] = "success|Buku berhasil dihapus!";
} else {
    $_SESSION['alert'] = "danger|Gagal menghapus buku!";
}

header("Location: buku.php");
exit;
?>
