<?php
include_once('../config/redirect.php');

$user_id = $user['id'];
$sql_guru = "SELECT * FROM detail_guru WHERE user_id = '$user_id'";
$result_guru = $conn->query($sql_guru);
$row_guru = $result_guru->fetch_assoc();
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
            <a href="<?= $url . '/' . $user['role'] ?>" class="btn btn-light-primary "><i class="bi bi-arrow-left"></i> Kembali</a>
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
                                    <th><?= $user['username'] ?></th>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th>:</th>
                                    <th><?= $user['email'] ?></th>
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
                                        <form action="<?= $url . "/config/guru/profile.php" ?>" method="post">
                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="detail_user_id" value="<?= $row_guru['id'] ?>">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="username">Username</label>
                                                            <input type="text" id="username" class="form-control"
                                                                placeholder="Username" name="username" value="<?= $user['username'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="nip">Nip</label>
                                                            <input type="text" id="nip" class="form-control"
                                                                placeholder="nip" name="nip" value="<?= $row_guru['nip'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="no_telp">No Telp</label>
                                                            <input type="number" id="no_telp" class="form-control"
                                                                placeholder="" name="no_telp" value="<?= $row_guru['no_telp'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="alamat">Alamat</label>
                                                            <textarea name="alamat" class="form-control" id="alamat" rows="3"><?= $row_guru['alamat'] ?></textarea>
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
                                <tr>
                                    <th>Nip</th>
                                    <th>:</th>
                                    <th><?= $row_guru['nip'] ?? '-' ?></th>
                                </tr>
                                <tr>
                                    <th>No Telp</th>
                                    <th>:</th>
                                    <th><?= $row_guru['no_telp'] ?? '-' ?></th>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <th><?= $row_guru['alamat'] ?? '-' ?></th>
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