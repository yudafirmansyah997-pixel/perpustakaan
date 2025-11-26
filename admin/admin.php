<?php
session_start();
if (!isset($_SESSION['admin'])) {
    $_SESSION['error'] = "Silakan login terlebih dahulu!";
    header("Location: /learnphp/admin/index.php");
    exit;
}
include "../main/connect.php";



// =====================
// PROSES TAMBAH ADMIN
// =====================
if (isset($_POST['tambah_admin'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = sha1($_POST['password']);

    mysqli_query($conn, "INSERT INTO admin (adminUsername, adminName, adminPassword, adminStatus, adminRegisterDate)
                         VALUES ('$username', '$nama', '$password', 'active', UNIX_TIMESTAMP())");

    $_SESSION['pesan'] = "Admin berhasil ditambahkan!";
    header("Location: admin.php");
    exit;
}

// =====================
// PROSES EDIT ADMIN
// =====================
if (isset($_POST['edit_admin'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    if ($password == "") {
        mysqli_query($conn, "UPDATE admin SET adminUsername='$username', adminName='$nama' WHERE adminID=$id");
    } else {
        $pass_hash = sha1($password);
        mysqli_query($conn, "UPDATE admin SET adminUsername='$username', adminName='$nama', adminPassword='$pass_hash' WHERE adminID=$id");
    }

    $_SESSION['pesan'] = "Data admin berhasil diperbarui!";
    header("Location: admin.php");
    exit;
}

// =====================
// PROSES NONAKTIF ADMIN
// =====================
if (isset($_POST['nonaktif_admin'])) {
    $id = $_POST['id'];
    mysqli_query($conn, "UPDATE admin SET adminStatus='inactive' WHERE adminID=$id");

    $_SESSION['pesan'] = "Admin berhasil dinonaktifkan!";
    header("Location: admin.php");
    exit;
}
?>



<?php include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/topbar.php"; ?>


<div class="content">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data Admin</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAdmin">+ Tambah Admin</button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-hover table-striped align-middle">
                <thead class="table-header-custom">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Last Login</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM admin ORDER BY adminId ASC");
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?= $row['adminId']; ?></td>
                            <td><?= $row['adminUsername']; ?></td>
                            <td><?= $row['adminName']; ?></td>
                            <td><?= $row['adminLastLogin'] == 0 ? '-' : date("Y-m-d", $row['adminLastLogin']); ?></td>
                            <td>
                                <?= $row['adminStatus'] == 'active'
                                    ? '<span class="badge bg-success">Active</span>'
                                    : '<span class="badge bg-danger">Inactive</span>' ?>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['adminId'] ?>">Edit</button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalNonaktif<?= $row['adminId'] ?>">Nonaktifkan</button>
                            </td>
                        </tr>


                        <!-- Modal Edit Admin -->
                        <div class="modal fade" id="modalEdit<?= $row['adminId'] ?>" tabindex="-1">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-warning">
                                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Admin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                              <form action="admin.php" method="post">
                                <input type="hidden" name="edit_admin" value="1">
                                <input type="hidden" name="id" value="<?= $row['adminId'] ?>">

                                <div class="modal-body">
                                  <label>Username</label>
                                  <input type="text" name="username" class="form-control" value="<?= $row['adminUsername'] ?>" required>

                                  <label class="mt-3">Nama Admin</label>
                                  <input type="text" name="nama" class="form-control" value="<?= $row['adminName'] ?>" required>

                                  <label class="mt-3">Password Baru (Opsional)</label>
                                  <input type="password" name="password" class="form-control" placeholder="Isi jika ingin ubah password">
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-warning">Update</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>


                        <!-- Modal Nonaktif Admin -->
                        <div class="modal fade" id="modalNonaktif<?= $row['adminId'] ?>" tabindex="-1">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="bi bi-x-circle"></i> Nonaktifkan Admin</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                              </div>

                              <form action="admin.php" method="post">
                                <input type="hidden" name="nonaktif_admin" value="1">
                                <input type="hidden" name="id" value="<?= $row['adminId'] ?>">

                                <div class="modal-body text-center">
                                  <p>Yakin ingin menonaktifkan admin <strong><?= $row['adminUsername'] ?></strong>?</p>
                                </div>

                                <div class="modal-footer justify-content-center">
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


<!-- Modal Tambah Admin -->
<div class="modal fade" id="modalTambahAdmin" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-person-plus"></i> Tambah Admin</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="admin.php" method="post">
        <input type="hidden" name="tambah_admin" value="1">

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Nama Admin</label>
            <input type="text" name="nama" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
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
