<?php include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/topbar.php"; ?>
<?php include "../main/connect.php"; ?>
<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>

<div class="content">

    <div class="d-flex justify-content-between mb-3">
        <h3>Peminjaman Buku</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPinjam">
            + Tambah Peminjaman
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchPeminjaman" class="form-control" placeholder="Cari siswa, buku, tanggal...">
                </div>
            </div>

            <table class="table table-hover table-striped align-middle">
                <thead class="table-header-custom">
                    <tr>
                        <th>ID</th>
                        <th>Siswa</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Admin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $query = mysqli_query($conn,
                    "SELECT p.*, s.siswaName, b.bukuJudul, a.adminName 
                     FROM peminjaman p
                     LEFT JOIN siswa s ON p.siswaId = s.siswaId
                     LEFT JOIN buku b ON p.bukuId = b.bukuId
                     LEFT JOIN admin a ON p.adminId = a.adminId
                     ORDER BY p.peminjamId ASC"
                );
                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                    <tr>
                        <td><?= $row['peminjamId']; ?></td>
                        <td><?= $row['siswaName']; ?></td>
                        <td><?= $row['bukuJudul']; ?></td>
                        <td><?= date("Y-m-d", $row['peminjamTanggalPinjam']); ?></td>
                        <td><?= $row['peminjamTanggalKembali'] == 0 ? "-" : date("Y-m-d", $row['peminjamTanggalKembali']); ?></td>
                        <td><?= $row['adminName'] ? $row['adminName'] : "-"; ?></td>
                        <td>
                            <?php if ($row['peminjamTanggalKembali'] == 0) { ?>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalKembalikan<?= $row['peminjamId']; ?>">
                                Kembalikan
                            </button>
                            <?php } ?>
                        </td>
                    </tr>

                    <!-- Modal Kembalikan -->
                    <div class="modal fade" id="modalKembalikan<?= $row['peminjamId']; ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="bi bi-check-circle"></i> Kembalikan Buku</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                          </div>

                          <form action="peminjaman_kembali.php" method="post">
                            <div class="modal-body text-center">
                              <input type="hidden" name="id" value="<?= $row['peminjamId']; ?>">
                              <p>Konfirmasi pengembalian buku <strong><?= $row['bukuJudul']; ?></strong>?</p>
                              <label class="form-label mt-2">Tanggal Kembali</label>
                              <input type="date" name="tglKembali" class="form-control" required>
                            </div>
                            <div class="modal-footer justify-content-center">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-success">Kembalikan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Modal Tambah Peminjaman -->
<div class="modal fade" id="modalTambahPinjam" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-journal-plus"></i> Tambah Peminjaman</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="peminjaman_add.php" method="post">
        <div class="modal-body">

          <?php if(isset($_SESSION['adminId'])) { ?>
            <input type="hidden" name="adminId" value="<?= $_SESSION['adminId']; ?>">
          <?php } ?>

          <div class="mb-3">
            <label class="form-label">Pilih Siswa</label>
            <select name="siswaId" class="form-select" required>
              <option value="">-- Pilih Siswa --</option>
              <?php
              $students = mysqli_query($conn, "SELECT * FROM siswa WHERE siswaStatus='active'");
              while ($s = mysqli_fetch_assoc($students)) {
              ?>
                <option value="<?= $s['siswaId']; ?>"><?= $s['siswaName']; ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Pilih Buku</label>
            <select name="bukuId" class="form-select" required>
              <option value="">-- Pilih Buku --</option>
              <?php
              $books = mysqli_query($conn, "SELECT bukuId, bukuJudul FROM buku");
              while ($b = mysqli_fetch_assoc($books)) {
              ?>
                <option value="<?= $b['bukuId']; ?>"><?= $b['bukuJudul']; ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tglPinjam" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Tanggal Kembali</label>
            <input type="date" name="tglKembali" class="form-control">
            <small class="text-muted">Kosongkan jika belum dikembalikan</small>
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

<script>
document.getElementById("searchPeminjaman").addEventListener("keyup", function () {
    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll("table tbody tr");
    rows.forEach(row => row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none");
});
</script>

<?php include "inc/footer.php"; ?>
