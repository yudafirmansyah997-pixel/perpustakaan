<?php
session_start();
if (!isset($_SESSION['admin'])) {
    $_SESSION['error'] = "Silakan login terlebih dahulu!";
    header("Location: /learnphp/admin/index.php");
    exit;
}

include "../main/connect.php";
?>
<?php include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/topbar.php"; ?>

<?php
// hitung total siswa (yang masih active)
$total_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM siswa WHERE siswaStatus='active'"))['total'];

// hitung total buku (semua stock dijumlahkan)
$total_buku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(bukuStock) AS total FROM buku"))['total'];
if ($total_buku == "" || $total_buku == null) $total_buku = 0;

// hitung semua peminjaman
$total_pinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM peminjaman"))['total'];

// hitung peminjaman yang belum dikembalikan
$belum_kembali = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM peminjaman WHERE peminjamTanggalKembali = 0"))['total'];
?>

<style>
    .info-box {
        color: white;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        padding: 20px;
        cursor: pointer;
        transition: 0.2s;
    }
    .info-box i.bg-icon {
        position: absolute;
        right: 15px;
        bottom: 50px;
        font-size: 70px;
        opacity: 0.2;
    }
    .more-info {
        background: rgba(0,0,0,0.1);
        display: block;
        text-align: center;
        padding: 8px;
        border-radius: 0 0 10px 10px;
        margin-top: 20px;
        font-weight: 500;
        color: white;
        text-decoration: none !important;
    }
    .more-info:hover {
        background: rgba(0,0,0,0.2);
        text-decoration: none !important;
    }
</style>

<div class="content">

    <h3 class="mb-4">Dashboard</h3>

    <div class="row g-4">

        <!-- TOTAL SISWA -->
        <div class="col-md-3">
            <div class="info-box" style="background:#17a2b8;">
                <h2><?= $total_siswa ?></h2>
                <h6>Data Siswa</h6>
                <i class="bi bi-people bg-icon"></i>
                <a href="siswa.php" class="more-info">lebih lanjut <i class="bi bi-arrow-right-circle"></i></a>
            </div>
        </div>

        <!-- TOTAL BUKU -->
        <div class="col-md-3">
            <div class="info-box" style="background:#28a745;">
                <h2><?= $total_buku ?></h2>
                <h6>Total Buku</h6>
                <i class="bi bi-book bg-icon"></i>
                <a href="buku.php" class="more-info">lebih lanjut <i class="bi bi-arrow-right-circle"></i></a>
            </div>
        </div>

        <!-- PEMINJAMAN -->
        <div class="col-md-3">
            <div class="info-box" style="background:#ffc107; color:black;">
                <h2><?= $total_pinjam ?></h2>
                <h6>Peminjaman</h6>
                <i class="bi bi-arrow-left-right bg-icon"></i>
                <a href="peminjaman.php" class="more-info" style="color:black;">lebih lanjut <i class="bi bi-arrow-right-circle"></i></a>
            </div>
        </div>

        <!-- BELUM KEMBALI -->
        <div class="col-md-3">
            <div class="info-box" style="background:#dc3545;">
                <h2><?= $belum_kembali ?></h2>
                <h6>Belum Kembali</h6>
                <i class="bi bi-clock-history bg-icon"></i>
                <a href="peminjaman.php" class="more-info">lebih lanjut <i class="bi bi-arrow-right-circle"></i></a>
            </div>
        </div>

    </div>
</div>

<?php include "inc/footer.php"; ?>
