<?php
session_start();
include "../main/connect.php";

// ambil data dari form
$siswaId   = $_POST['siswaId'];
$bukuId    = $_POST['bukuId'];
$tglPinjam = strtotime($_POST['tglPinjam']);
$tglKembali = !empty($_POST['tglKembali']) ? strtotime($_POST['tglKembali']) : 0;

// ambil admin id dari session
$adminId = $_SESSION['admin']['adminId'];

// insert ke tabel peminjaman
mysqli_query($conn, "INSERT INTO peminjaman (siswaId, bukuId, peminjamTanggalPinjam, peminjamTanggalKembali, adminId)
                     VALUES ('$siswaId', '$bukuId', '$tglPinjam', '$tglKembali', '$adminId')");

// kurangi stok buku
mysqli_query($conn, "UPDATE buku SET bukuStock = bukuStock - 1 WHERE bukuId = '$bukuId'");

header("Location: peminjaman.php");
exit;
