<?php
include_once('../config/redirect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "tambah user"; ?>
    <?php include_once("../layout/header-link.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include_once("../layout/sidebar.php") ?>

        <div id="main">
            <?php include_once("../layout/header.php") ?>


            <div class="page-heading">
                <h3>info users</h3>
            </div>
            <div class="page-content">
                <?php include_once('../layout/flash_alert.php') ?>
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end align-items-center mb-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#tambahUser">Tambah user</button>
                                </div>
                                <form action="" method="get" class="mb-3">
                                    <div class="d-flex gap-1">
                                        <input type="text" class="form-control" style="flex:4" name="cari" placeholder="cari user" value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
                                        <select name="role" id="role" class="form-control" style="flex:.5">
                                            <option value="" selected disabled>Role</option>
                                            <option value="admin" <?= isset($_GET['role']) && $_GET['role'] == 'admin' ? 'selected' : '' ?>>admin</option>
                                            <option value="guru" <?= isset($_GET['role']) && $_GET['role'] == 'guru' ? 'selected' : '' ?>>guru</option>
                                            <option value="siswa" <?= isset($_GET['role']) && $_GET['role'] == 'siswa' ? 'selected' : '' ?>>siswa</option>
                                            <option value="all" <?= isset($_GET['role']) && $_GET['role'] == 'all' ? 'selected' : '' ?>>semua</option>
                                        </select>
                                        <button class="btn btn-primary" style="flex:.5"><i class="bi bi-search"></i></button>
                                    </div>
                                </form>
                                <hr>
                                <!-- start tambah user -->
                                <div class="modal fade" id="tambahUser" tabindex="-1" role="dialog"
                                    aria-labelledby="tambahUserTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="tambahUserTitle">Tambah user</h5>
                                                <button type="button" class="btn" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <form action='<?= $url . "/config/admin/users.php" ?>' class="form" method="post">
                                                <div class="modal-body">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="username">Username</label>
                                                                <input type="text" id="username" class="form-control"
                                                                    placeholder="Username" name="username">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="role">Role</label>
                                                                <select name="role" id="role" class="form-control" onchange="roleAkses(this)">
                                                                    <option value="admin">admin</option>
                                                                    <option value="guru">guru</option>
                                                                    <option value="siswa">siswa</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div id="role_guru" class="d-none">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="nip">Nip</label>
                                                                    <input type="number" id="nip" class="form-control"
                                                                        placeholder="nip" name="nip">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="role_siswa" class="d-none">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="nisn">Nisn</label>
                                                                    <input type="text" id="nisn" class="form-control"
                                                                        placeholder="nisn" name="nisn">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="role_not_admin" class="d-none">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="noTelp">No Telp</label>
                                                                    <input type="number" id="noTelp" class="form-control"
                                                                        placeholder="noTelp" name="noTelp">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="text" id="email" class="form-control"
                                                                    placeholder="email" name="email">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="password">password</label>
                                                                <input type="password" id="password" class="form-control"
                                                                    placeholder="password" name="password">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bi bi-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">batal</span>
                                                    </button>

                                                    <button type="submit" name="tambah_user" class="btn btn-primary ms-1">
                                                        <i class="bi bi-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">lanjut</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tambah user -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (isset($_GET['cari'])) {
                                            $cari = $_GET['cari'];
                                            $sql = "SELECT * FROM users WHERE username LIKE '%$cari%'";
                                        } else {
                                            $sql = "SELECT * FROM users ";
                                        }
                                        if (isset($_GET['role'])) {
                                            $role = $_GET['role'];
                                            if ($role != 'all') {
                                                $sql .= " AND role = '$role'";
                                            }
                                        }
                                        $result = mysqli_query($conn, $sql);
                                        foreach ($result as $key => $value) {
                                        ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td>
                                                    <?php
                                                    if ($value['role'] != 'admin') {
                                                    ?>
                                                        <a href="<?= $url . "/admin/profile.php?user=" . $value['id'] . "&role=" . $value['role'] ?>"><?= $value['username'] ?></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <?= $value['username'] ?>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $value['role'] ?></td>
                                                <td>
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#editUser_<?= $value['id']; ?>"><i class="bi bi-pencil-square"></i></button>
                                                        <button class="btn btn-danger btn-sm text-light" data-bs-toggle="modal"
                                                            data-bs-target="#hapus_user_<?= $value['id'] ?>"><i class="bi bi-trash2"></i></button>



                                                        <!-- start hapus kelas -->
                                                        <div class="modal fade" id="hapus_user_<?= $value['id'] ?>" tabindex="-1" role="dialog"
                                                            aria-labelledby="hapus_user_<?= $value['id'] ?>Title" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="hapus_user_<?= $value['id'] ?>Title">Hapus Kelas</h5>
                                                                        <button type="button" class="btn" data-bs-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <i class="bi bi-x"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h6>Yakin ingin menghapus user <b><?= $value['username'] ?></b> dengan role <b><?= $value['role'] ?></b>?</h6>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light-secondary"
                                                                            data-bs-dismiss="modal">
                                                                            <i class="bi bi-x d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">tutup</span>
                                                                        </button>
                                                                        <form action='<?= $url . "/config/admin/users.php" ?>' method="post">
                                                                            <input type="hidden" name="user_id" value="<?= $value['id'] ?>">
                                                                            <button type="submit" name="hapus_user" class="btn btn-light-danger">
                                                                                <i class="bi bi-check d-block d-sm-none"></i>
                                                                                <span class="d-none d-sm-block">lanjut</span>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end hapus kelas -->

                                                        <!-- start edit user -->
                                                        <div class="modal fade" id="editUser_<?= $value['id']; ?>" tabindex="-1" role="dialog"
                                                            aria-labelledby="editUser_<?= $value['id']; ?>Title" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editUser_<?= $value['id']; ?>Title">Edit user</h5>
                                                                        <button type="button" class="btn" data-bs-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <i class="bi bi-x"></i>
                                                                        </button>
                                                                    </div>
                                                                    <form action='<?= $url . "/config/admin/users.php" ?>' class="form" method="post">
                                                                        <div class="modal-body">
                                                                            <input type="hidden" name="user_id" value="<?= $value['id'] ?>">
                                                                            <input type="hidden" name="password_db" value="<?= $value['password'] ?>">

                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="nama">Nama</label>
                                                                                        <input type="text" id="nama" class="form-control"
                                                                                            placeholder="username" name="username" value="<?= $value['username'] ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="role" value="<?= $value['role'] ?>">

                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="email">Email</label>
                                                                                        <input type="text" id="email" class="form-control"
                                                                                            placeholder="email" name="email" value="<?= $value['email'] ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="password">password</label>
                                                                                        <input type="password" id="password" class="form-control"
                                                                                            placeholder="password" name="password">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-light-secondary"
                                                                                data-bs-dismiss="modal">
                                                                                <i class="bi bi-x d-block d-sm-none"></i>
                                                                                <span class="d-none d-sm-block">batal</span>
                                                                            </button>

                                                                            <button type="submit" name="edit_user" class="btn btn-primary ms-1">
                                                                                <i class="bi bi-check d-block d-sm-none"></i>
                                                                                <span class="d-none d-sm-block">lanjut</span>
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end edit user -->
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include_once("../layout/footer.php") ?>
        </div>
    </div>
    <?php include_once("../layout/footer-link.php") ?>
    <script>
        function roleAkses(el) {
            const role = el.value;
            if (role == "admin") {
                document.getElementById("role_guru").classList.add("d-none");
                document.getElementById("role_siswa").classList.add("d-none");
                document.getElementById("role_not_admin").classList.add("d-none");
            } else if (role == "guru") {
                document.getElementById("role_guru").classList.remove("d-none");
                document.getElementById("role_siswa").classList.add("d-none");
                document.getElementById("role_not_admin").classList.remove("d-none");
            } else if (role == "siswa") {
                document.getElementById("role_guru").classList.add("d-none");
                document.getElementById("role_siswa").classList.remove("d-none");
                document.getElementById("role_not_admin").classList.remove("d-none");
            }
        }
    </script>
</body>

</html>