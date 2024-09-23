<?php
include_once('../config/redirect.php');

$user_id = $_GET['user'];
$role = $_GET['role'];
if (empty($user_id) || empty($role)) {
    header("location: " . $url . "/admin/users.php");
}

$sql_user = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = $conn->query($sql_user);
$hasil_user = $result_user->fetch_assoc();
if (empty($hasil_user)) {
    header("location: " . $url . "/admin/users.php");
}

if ($role == 'guru') {
    $sql_detail = "SELECT * FROM detail_guru WHERE user_id = '$user_id'";
} else if ($role == 'siswa') {
    $sql_detail = "SELECT * FROM detail_peserta WHERE user_id = '$user_id'";
} else {
    header("location: " . $url . "/admin/users.php");
}

$result_detail = $conn->query($sql_detail);
$hasil_detail = $result_detail->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "kelas"; ?>
    <?php include_once("../layout/header-link.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div class="container mt-5">
        <div class="page-heading">
            <a href="<?= $url . '/' . $hasil_user['role'] ?>" class="btn btn-light-primary "><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="page-content">
            <?php include_once('../layout/flash_alert.php') ?>
            <section class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Username</th>
                                    <th>:</th>
                                    <th><?= $hasil_user['username'] ?></th>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th>:</th>
                                    <th><?= $hasil_user['email'] ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-end">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit"><i class="bi bi-pencil-square"></i> Edit</button>
                            </div>
                            <!-- start edit profile -->
                            <div class="modal fade" id="edit" tabindex="-1" role="dialog"
                                aria-labelledby="editTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editTitle">Edit profile</h5>
                                            <button type="button" class="btn" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                        <form action="<?= $url . "/config/admin/profile.php" ?>" method="post">
                                            <input type="hidden" name="user_id" value="<?= $hasil_user['id'] ?>">
                                            <input type="hidden" name="detail_user_id" value="<?= $hasil_detail['id'] ?>">
                                            <input type="hidden" name="role" value="<?= $hasil_user['role'] ?>">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="username">Username</label>
                                                            <input type="text" id="username" class="form-control"
                                                                placeholder="Username" name="username" value="<?= $hasil_user['username'] ?>">
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($role == 'guru') {
                                                    ?>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="nip">Nip</label>
                                                                <input type="text" id="nip" class="form-control"
                                                                    placeholder="nip" name="nip" value="<?= $hasil_detail['nip'] ?>">
                                                            </div>
                                                        </div>
                                                    <?php
                                                    } else if ($role == 'siswa') {
                                                    ?>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="nisn">Nisn</label>
                                                                <input type="text" id="nisn" class="form-control"
                                                                    placeholder="nisn" name="nisn" value="<?= $hasil_detail['nisn'] ?>">
                                                            </div>
                                                        </div>
                                                    <?php }  ?>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="no_telp">No Telp</label>
                                                            <input type="number" id="no_telp" class="form-control"
                                                                placeholder="" name="no_telp" value="<?= $hasil_detail['no_telp'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="alamat">Alamat</label>
                                                            <textarea name="alamat" class="form-control" id="alamat" rows="3"><?= $hasil_detail['alamat'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="bi bi-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">tutup</span>
                                                </button>
                                                <button type="submit" name="edit" class="btn btn-light-primary">
                                                    <i class="bi bi-check d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">simpan</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end edit profile -->
                            <table class="table">
                                <?php
                                if ($role == 'guru') {
                                ?>
                                    <tr>
                                        <th>Nip</th>
                                        <th>:</th>
                                        <th><?= $hasil_detail['nip'] ?? '-' ?></th>
                                    </tr>
                                <?php
                                } else if ($role == 'siswa') {
                                ?>
                                    <tr>
                                        <th>Nisn</th>
                                        <th>:</th>
                                        <th><?= $hasil_detail['nisn'] ?? '-' ?></th>
                                    </tr>
                                <?php }  ?>
                                <tr>
                                    <th>No Telp</th>
                                    <th>:</th>
                                    <th><?= $hasil_detail['no_telp'] ?? '-' ?></th>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <th><?= $hasil_detail['alamat'] ?? '-' ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include_once("../layout/footer.php") ?>
    </div>
    <?php include_once("../layout/footer-link.php") ?>


</body>

</html>