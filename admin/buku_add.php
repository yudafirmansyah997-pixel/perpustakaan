<?php
include "../main/connect.php";
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$judul     = $_POST['judul'];
$desc      = $_POST['desc'];
$penulis   = $_POST['penulis'];
$penerbit  = $_POST['penerbit'];
$tahun     = $_POST['tahun'];
$stok      = $_POST['stok'];

$sql = mysqli_query($conn, "INSERT INTO buku (BukuJudul, BukuDesc, BukuPenulis, BukuPenerbit, BukuTahun, BukuStock) 
                            VALUES ('$judul', '$desc', '$penulis', '$penerbit', '$tahun', '$stok')");

if ($sql) {
    $_SESSION['alert'] = "success|Buku berhasil ditambahkan!";
} else {
    $_SESSION['alert'] = "danger|Gagal menambahkan buku!";
}

header("Location: buku.php");
exit;
?>
