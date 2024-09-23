<?php
include_once('../config/redirect.php');

$user_id = $_GET['user'];
$role = $_GET['role'];
if (empty($user_id) || empty($role)) {
    header("location: " . $url . "/siswa/kelas.php");
}

$sql_user = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = $conn->query($sql_user);
$hasil_user = $result_user->fetch_assoc();
if (empty($hasil_user)) {
    header("location: " . $url . "/siswa/kelas.php");
}

if ($role == 'siswa') {
    $sql_detail = "SELECT * FROM detail_peserta WHERE user_id = '$user_id'";
} else {
    header("location: " . $url . "/siswa/kelas.php");
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
                            <table class="table">
                                <tr>
                                    <th>Nisn</th>
                                    <th>:</th>
                                    <th><?= $hasil_detail['nisn'] ?? '-' ?></th>
                                </tr>
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