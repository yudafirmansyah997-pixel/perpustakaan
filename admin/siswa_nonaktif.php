<?php
include "../main/connect.php";

$id = $_POST['id'];

mysqli_query($conn, "UPDATE siswa SET siswaStatus='inactive' WHERE siswaId=$id");

header("Location: siswa.php");
exit;
?>
