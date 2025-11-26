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


<div class="content">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data Buku</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBuku">
            + Tambah Buku
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari buku (Judul / Penulis / Penerbit / Tahun)...">
                </div>
            </div>

            <table class="table table-hover table-striped align-middle">
                <thead class="table-header-custom">
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $q = mysqli_query($conn, "SELECT * FROM buku ORDER BY bukuId ASC");
                while ($d = mysqli_fetch_assoc($q)):
                ?>
                    <tr>
                        <td><?= $d['bukuId']; ?></td>
                        <td><?= $d['bukuJudul']; ?></td>
                        <td><?= $d['bukuPenulis']; ?></td>
                        <td><?= $d['bukuPenerbit']; ?></td>
                        <td><?= $d['bukuTahun']; ?></td>
                        <td><?= $d['bukuStock']; ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detail<?= $d['bukuId']; ?>">Detail</button>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $d['bukuId']; ?>">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?= $d['bukuId']; ?>">Hapus</button>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detail<?= $d['bukuId']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Buku</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <h4><?= $d['bukuJudul']; ?></h4>
                                    <p><strong>Penulis:</strong> <?= $d['bukuPenulis']; ?></p>
                                    <p><strong>Penerbit:</strong> <?= $d['bukuPenerbit']; ?></p>
                                    <p><strong>Tahun:</strong> <?= $d['bukuTahun']; ?></p>
                                    <p><strong>Stok:</strong> <?= $d['bukuStock']; ?></p>
                                    <hr>
                                    <p><strong>Deskripsi:</strong></p>
                                    <p><?= nl2br($d['bukuDesc']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="edit<?= $d['bukuId']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Buku</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="buku_edit.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $d['bukuId']; ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Judul Buku</label>
                                            <input type="text" name="judul" class="form-control" value="<?= $d['bukuJudul']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea name="desc" class="form-control" rows="3"><?= $d['bukuDesc']; ?></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Penulis</label>
                                                <input type="text" name="penulis" class="form-control" value="<?= $d['bukuPenulis']; ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Penerbit</label>
                                                <input type="text" name="penerbit" class="form-control" value="<?= $d['bukuPenerbit']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Tahun</label>
                                                <input type="number" name="tahun" class="form-control" value="<?= $d['bukuTahun']; ?>" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Stok</label>
                                                <input type="number" name="stok" class="form-control" value="<?= $d['bukuStock']; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning text-white">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="hapus<?= $d['bukuId']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Buku</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="buku_hapus.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $d['bukuId']; ?>">
                                        <p>Apakah kamu yakin ingin menghapus buku:</p>
                                        <h5 class="text-danger">"<?= $d['bukuJudul']; ?>"?</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Tambah Buku -->
<div class="modal fade" id="modalTambahBuku" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-book"></i> Tambah Buku</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="buku_add.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="desc" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>

<script>
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    document.querySelectorAll("table tbody tr").forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(filter) ? "" : "none";
    });
});
</script>
