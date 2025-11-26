<?php
include "../main/connect.php";

$nis    = $_POST['nis'];
$nama   = $_POST['nama'];
$kelas  = $_POST['kelas'];
$hp     = $_POST['hp'];
$status = $_POST['status'];
$waktu  = time();

mysqli_query($conn, "INSERT INTO siswa (siswaNIS, siswaName, siswaClass, siswaHp, siswaStatus, siswaRegisterDate)
                     VALUES ('$nis', '$nama', '$kelas', '$hp', '$status', '$waktu')");

header("Location: siswa.php");
exit;
?>
