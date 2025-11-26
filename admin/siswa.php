<?php include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/topbar.php"; ?>
<?php include "../main/connect.php"; ?>


<div class="content">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data Siswa</h3>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
            + Tambah Siswa
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari siswa (NIS / Nama / Kelas)...">
                </div>
            </div>

            <table class="table table-hover table-striped align-middle">
                <thead class="table-header-custom">
                    <tr>
                        <th>ID</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $siswa = mysqli_query($conn, "SELECT * FROM siswa ORDER BY siswaId ASC");
                while ($row = mysqli_fetch_assoc($siswa)) {
                ?>
                    <tr>
                        <td><?= $row['siswaId'] ?></td>
                        <td><?= $row['siswaNIS'] ?></td>
                        <td><?= $row['siswaName'] ?></td>
                        <td><?= $row['siswaClass'] ?></td>
                        <td><?= $row['siswaHp'] ?></td>
                        <td>
                            <?= $row['siswaStatus'] == "active"
                                ? '<span class="badge bg-success">Active</span>'
                                : '<span class="badge bg-danger">Inactive</span>' ?>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSiswa<?= $row['siswaId'] ?>">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#nonaktifSiswa<?= $row['siswaId'] ?>">Nonaktifkan</button>
                        </td>
                    </tr>

                    <!-- Modal Edit Siswa -->
                    <div class="modal fade" id="editSiswa<?= $row['siswaId'] ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Siswa</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                          </div>

                          <form action="siswa_edit.php" method="post">
                            <div class="modal-body">
                              <input type="hidden" name="id" value="<?= $row['siswaId'] ?>">

                              <div class="mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control" value="<?= $row['siswaNIS'] ?>" required>
                              </div>

                              <div class="mb-3">
                                <label class="form-label">Nama Siswa</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['siswaName'] ?>" required>
                              </div>

                              <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control" value="<?= $row['siswaClass'] ?>" required>
                              </div>

                              <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" name="hp" class="form-control" value="<?= $row['siswaHp'] ?>">
                              </div>

                              <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" <?= $row['siswaStatus'] == "active" ? "selected" : "" ?>>Active</option>
                                    <option value="inactive" <?= $row['siswaStatus'] == "inactive" ? "selected" : "" ?>>Inactive</option>
                                </select>
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

                    <!-- Modal Nonaktifkan -->
                    <div class="modal fade" id="nonaktifSiswa<?= $row['siswaId'] ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title"><i class="bi bi-person-x"></i> Nonaktifkan Siswa</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                          </div>

                          <form action="siswa_nonaktif.php" method="post">
                            <div class="modal-body">
                              <input type="hidden" name="id" value="<?= $row['siswaId'] ?>">

                              <p>Apakah kamu yakin ingin menonaktifkan siswa:</p>
                              <h5 class="text-danger"><?= $row['siswaName'] ?> (NIS: <?= $row['siswaNIS'] ?>)</h5>

                              <small class="text-muted d-block mt-2">
                                Catatan: siswa yang dinonaktifkan tidak dapat meminjam buku lagi.
                              </small>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-danger">Nonaktifkan</button>
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



<!-- =================================== -->
<!-- Modal Tambah Siswa -->
<!-- =================================== -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-person-plus"></i> Tambah Siswa</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="siswa_add.php" method="post">
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">NIS</label>
            <input type="text" name="nis" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Nama Siswa</label>
            <input type="text" name="nama" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Kelas</label>
            <input type="text" name="kelas" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="hp" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
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



<!-- Filter Search -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("table tbody tr");
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

<?php include "inc/footer.php"; ?>
