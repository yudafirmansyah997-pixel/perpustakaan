<?php include "../main/connect.php"; ?>

<?php
// Ambil nama file halaman yang sedang dibuka
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    <h4 class="sidebar-title mb-4">
        <i class="bi bi-person-circle me-2"></i> Perpustakaan
    </h4>

    <ul class="nav flex-column">

        <li>
            <a href="dashboard.php" class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2 me-2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="siswa.php" class="nav-link <?= ($current_page == 'siswa.php') ? 'active' : '' ?>">
                <i class="bi bi-people me-2"></i>
                <span>Data Siswa</span>
            </a>
        </li>

        <li>
            <a href="buku.php" class="nav-link <?= ($current_page == 'buku.php') ? 'active' : '' ?>">
                <i class="bi bi-book me-2"></i>
                <span>Data Buku</span>
            </a>
        </li>

        <li>
            <a href="peminjaman.php" class="nav-link <?= ($current_page == 'peminjaman.php') ? 'active' : '' ?>">
                <i class="bi bi-arrow-left-right me-2"></i>
                <span>Peminjaman</span>
            </a>
        </li>

        <li>
            <a href="admin.php" class="nav-link <?= ($current_page == 'admin.php') ? 'active' : '' ?>">
                <i class="bi bi-person-badge me-2"></i>
                <span>Data Admin</span>
            </a>
        </li>

        <li>
            <a href="logout.php" class="nav-link text-danger mt-4" onclick="return confirmLogout()"> 
                <i class="bi bi-box-arrow-right me-2"></i>
                <span class="text-danger">Logout</span>
            </a>
            <script>
                function confirmLogout() {
                    if (confirm("Yakin mau logout?")) {
                        window.location.href = "logout.php";
                    }
                    return false;
                }
            </script>
        </li>

    </ul>
</div>
