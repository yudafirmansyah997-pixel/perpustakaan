<?php
session_start();
include "../main/connect.php";

$id = $_POST['id'];
$tglKembali = strtotime($_POST['tglKembali']);

// ambil bukuId dari tabel peminjaman
$d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT bukuId FROM peminjaman WHERE peminjamId='$id'"));
$bukuId = $d['bukuId'];

// update tanggal kembali
mysqli_query($conn, "UPDATE peminjaman SET peminjamTanggalKembali='$tglKembali' WHERE peminjamId='$id'");

// TAMBAHKAN YANG NOMOR 2 DI SINI ↓↓↓
mysqli_query($conn, "UPDATE buku SET bukuStock = bukuStock + 1 WHERE bukuId='$bukuId'");

header("Location: peminjaman.php");
exit;
