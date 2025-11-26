<?php include "../main/connect.php"; ?>


<?php
session_start();
session_unset();   // hapus semua data session
session_destroy(); // hancurkan session

header("Location: index.php"); // kembali ke form login
exit;
