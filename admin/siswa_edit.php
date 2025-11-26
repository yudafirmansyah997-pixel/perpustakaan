<?php
include "../main/connect.php";

$id     = $_POST['id'];
$nis    = $_POST['nis'];
$nama   = $_POST['nama'];
$kelas  = $_POST['kelas'];
$hp     = $_POST['hp'];
$status = $_POST['status'];

mysqli_query($conn, "UPDATE siswa SET
                        siswaNIS='$nis',
                        siswaName='$nama',
                        siswaClass='$kelas',
                        siswaHp='$hp',
                        siswaStatus='$status'
                     WHERE siswaId=$id");

header("Location: siswa.php");
exit;
?>
