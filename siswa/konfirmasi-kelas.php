<?php
include_once('../config/redirect.php');

if (empty($_POST['token'])) {
    $_SESSION['flash_alert'] = [
        'type' => 'warning',
        'pesan' => 'masukkan token untuk bergabung'
    ];
    // header("location: " . $url . "/siswa/kelas.php");
} else {
    $token = $_POST['token'];
    $cari_kelas = "SELECT * FROM kelas 
 INNER JOIN users ON kelas.guru_id = users.id
 WHERE token = '$token'";
    $query_kelas = $conn->query($cari_kelas);
    $data_kelas = $query_kelas->fetch_assoc();
    if (!$data_kelas) {
        $_SESSION['flash_alert'] = [
            'type' => 'warning',
            'pesan' => 'token tidak sesuai'
        ];
        // header("location: " . $url . "/siswa/kelas.php");
    }
    // print_r($data_kelas);
    // die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "masuk kelas"; ?>
    <?php include_once("../layout/header-link.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div class="container mt-5">
        <div class="page-heading">
            <a href="<?= $url . '/' . $user['role'] . '/kelas.php' ?>" class="btn btn-light-primary "><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="page-content">
            <?php include_once('../layout/flash_alert.php') ?>
            <?php
            if ($data_kelas ?? false) {
            ?>
                <section class="row justify-content-center">
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center flex-column text-center" style="height: 200px;">
                                <p>Lanjut Masuk kelas <b><?= $data_kelas['nama_kelas'] ?></b></p>
                                <small>guru : <?= $data_kelas['username'] ?></small>
                                <br>
                                <form action="<?= $url . "/config/siswa/masuk-kelas.php" ?>" method="post" class="d-flex gap-2">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="token" value="<?= $data_kelas['token'] ?>">
                                    <button type="submit" name="masuk_kelas" class="btn btn-primary d-block w-100">Masuk</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            <?php
            }
            ?>
        </div>
        <?php include_once("../layout/footer.php") ?>
    </div>
    <?php include_once("../layout/footer-link.php") ?>


</body>

</html>