<?php
include_once('../config/redirect.php');

$user_id = $_GET['user'];
$role = $_GET['role'];
if (empty($user_id) || empty($role)) {
    header("location: " . $url . "/guru/kelas.php");
}

$sql_user = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = $conn->query($sql_user);
$hasil_user = $result_user->fetch_assoc();
if (empty($hasil_user)) {
    header("location: " . $url . "/guru/kelas.php");
}

if ($role == 'siswa') {
    $sql_detail = "SELECT * FROM detail_peserta WHERE user_id = '$user_id'";
} else {
    header("location: " . $url . "/guru/kelas.php");
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

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelas</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <?php
                                $user_id = $_GET['user'];

                                $cari_guru = "SELECT id,username FROM users WHERE role = 'guru'";
                                $result_guru = $conn->query($cari_guru);
                                $data_guru = [];
                                foreach ($result_guru as $guru) {
                                    $data_guru[] = $guru;
                                }

                                $sql_kelas = "SELECT * FROM peserta
                                INNER JOIN kelas ON peserta.kelas_id = kelas.id
                                INNER JOIN jadwal ON kelas.id = jadwal.kelas_id
                                INNER JOIN users ON peserta.user_id = users.id
                                WHERE peserta.user_id = '$user_id'
                                ";
                                $result_kelas = $conn->query($sql_kelas);
                                $data_kelas = [];
                                foreach ($result_kelas as $kelas) {
                                    $data_kelas[] = $kelas;
                                }
                                ?>
                                <tbody>
                                    <?php
                                    foreach ($data_kelas as $index => $value) {
                                    ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $value['nama_kelas'] ?></td>
                                            <td><?= $value['tanggal_mulai'] ?> - <?= $value['tanggal_berakhir'] ?></td>
                                            <td><?= $value['waktu_mulai'] ?> - <?= $value['waktu_selesai'] ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <?php
                                                    if ($value['tanggal_mulai'] <=  date('Y-m-d') && $value['tanggal_berakhir'] >=  date('Y-m-d')) {
                                                        echo "<span class='badge bg-light-success'>active</span>";
                                                        if ($value['waktu_mulai'] <= date('H:i:s') && $value['waktu_selesai'] >= date('H:i:s')) {
                                                            echo "<span class='badge bg-light-success'>berlangsung</span>";
                                                        } else {
                                                            echo "<span class='badge bg-light-danger'>berakhir</span>";
                                                        }
                                                    } else {
                                                        echo "<span class='badge bg-light-danger'>non active</span>";
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-light-primary btn-sm text-light" data-bs-toggle="modal"
                                                    data-bs-target="#detail_<?= $value['kelas_id'] ?>"><i class="bi bi-eye"></i></button>
                                                <!-- start detail kelas -->
                                                <div class="modal fade" id="detail_<?= $value['kelas_id'] ?>" tabindex="-1" role="dialog"
                                                    aria-labelledby="detail_<?= $value['kelas_id'] ?>Title" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detail_<?= $value['kelas_id'] ?>Title">Detail Kelas</h5>
                                                                <button type="button" class="btn" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i class="bi bi-x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <small>Guru / Pembimbing : <?php
                                                                                            foreach ($data_guru as $guru) {
                                                                                                if ($value['guru_id'] == $guru['id']) {
                                                                                                    echo $guru['username'];
                                                                                                }
                                                                                            }
                                                                                            ?></small>
                                                                <hr>
                                                                <p><b>Pesan</b>: <?= $value['pesan'] ?></p>
                                                                <p><b>Deskripsi</b>: <?= $value['deskripsi'] ?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bi bi-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">tutup</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end detail kelas -->
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
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