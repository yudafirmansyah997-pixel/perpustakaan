<?php
include "../main/connect.php";
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$id        = $_POST['id'];
$judul     = $_POST['judul'];
$desc      = $_POST['desc'];
$penulis   = $_POST['penulis'];
$penerbit  = $_POST['penerbit'];
$tahun     = $_POST['tahun'];
$stok      = $_POST['stok'];

$sql = mysqli_query($conn, "UPDATE buku SET 
                            BukuJudul='$judul',
                            BukuDesc='$desc',
                            BukuPenulis='$penulis',
                            BukuPenerbit='$penerbit',
                            BukuTahun='$tahun',
                            BukuStock='$stok'
                            WHERE bukuId='$id'");

if ($sql) {
    $_SESSION['alert'] = "success|Perubahan data buku disimpan!";
} else {
    $_SESSION['alert'] = "danger|Gagal memperbarui buku!";
}

header("Location: buku.php");
exit;
?>
