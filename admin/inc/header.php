
<?php include "../main/connect.php"; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    $_SESSION['error'] = "Silakan login terlebih dahulu!";
    header("Location: /learnphp/admin/index.php");
    exit;
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin perpus</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body { background: #f8f9fc; font-family: 'Poppins', sans-serif; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #090f4fff;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            color: white;
            transition: 0.3s;
        }

        /* COLLAPSE */
        .sidebar.collapsed {
            width: 70px;
        }

        /* Sidebar title */
        .sidebar-title {
    padding-left: 20px;
    font-size: 20px;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 15px;
    position: relative;
}

/* GARIS BAWAH */
     .table-header-custom th {
    background: #08074bff !important;   /* warna custom */
    color: #ffffff !important;
}



        .sidebar.collapsed .sidebar-title {
            font-size: 0;
            opacity: 0;
        }

        /* NAV LINK */
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
        }

        .sidebar .nav-link i {
            font-size: 20px;
        }

        /* Hide text when collapsed */
        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar .nav-link:hover,
        .sidebar .active {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        /* ===== CONTENT ===== */
        .content {
            margin-left: 250px;
            padding: 25px;
            transition: 0.3s;
        }

        .content.collapsed {
            margin-left: 70px;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            height: 60px;
            background: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 0 20px;
            margin-left: 250px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 10;
            transition: 0.3s;
        }

        .topbar.collapsed {
            margin-left: 70px;
        }
        #sidebarToggle {
    transition: 0.25s;
    border-radius: 5px;
    padding: 6px 5px;
}

#sidebarToggle:hover {
    background-color: #e5e7ff;   /* warna hover */
    color: #08074b;              /* icon berubah warna */
}
.sidebar .nav-link.active {
    background: #ffffff !important;
    color: #090f4f !important;
    font-weight: 600;
    border-radius: 4px;
}

.sidebar .nav-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    width: 4px;
    height: 100%;
    background: #00e1ff;
    border-radius: 0 4px 4px 0;
}

/* Biar posisi relatif utk indikator */
.sidebar .nav-link {
    position: relative;
}



    </style>
</head>
<body>
