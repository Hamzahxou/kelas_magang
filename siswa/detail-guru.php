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

if ($role == 'guru') {
    $sql_detail = "SELECT * FROM detail_guru WHERE user_id = '$user_id'";
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
            <a href="<?= $_SERVER['HTTP_REFERER'] ?? $url . '/' . $hasil_user['role'] ?>" class="btn btn-light-primary "><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="page-content">
            <?php include_once('../layout/flash_alert.php') ?>
            <section class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <?php
                                if ($hasil_detail['avatar'] != null) {
                                ?>
                                    <img src="<?= $url . "/assets/static/images/faces/" . $hasil_detail['avatar'] ?>" width="150px" alt="Profile" class="img-fluid rounded-circle mb-3">
                                <?php
                                } else {
                                ?>
                                    <img src="<?= $url . "/assets/static/images/faces/1.jpg" ?>" width="150px" alt="Profile" class="img-fluid rounded-circle mb-3">
                                <?php
                                }
                                ?>
                            </center>
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
                                    <th>Nip</th>
                                    <th>:</th>
                                    <th><?= $hasil_detail['nip'] ?? '-' ?></th>
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
                            <div class="table-responsive">
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

                                    <tbody>
                                        <?php

                                        $peserta = "SELECT id,username FROM users WHERE role = 'siswa'";
                                        $data_peserta = $conn->query($peserta);

                                        $sql = "SELECT * FROM kelas
                                        LEFT JOIN jadwal ON kelas.id = jadwal.kelas_id
                                        JOIN users ON kelas.guru_id = users.id
                                        WHERE guru_id = '$user_id'
                                        ";

                                        $result = $conn->query($sql);

                                        $sql_peserta = "SELECT user_id,kelas_id,username FROM peserta 
                                        INNER JOIN users ON peserta.user_id = users.id
                                        ";
                                        $query_peserta = $conn->query($sql_peserta);
                                        $result_peserta = [];
                                        foreach ($query_peserta as $peserta) {
                                            $result_peserta[] = $peserta;
                                        }

                                        $data = [];
                                        foreach ($result as $i => $baris) {
                                            $kelas_id = $baris['kelas_id'];
                                            if (!isset($data[$kelas_id])) {
                                                $data[$kelas_id] = [
                                                    'id' => $i,
                                                    'waktu_mulai' => $baris['waktu_mulai'],
                                                    'waktu_selesai' => $baris['waktu_selesai'],
                                                    'pesan' => $baris['pesan'],
                                                    'kelas_id' => $baris['kelas_id'],
                                                    'username' => $baris['username'],
                                                    'nama_kelas' => $baris['nama_kelas'],
                                                    'deskripsi' => $baris['deskripsi'],
                                                    'tanggal_mulai' => $baris['tanggal_mulai'],
                                                    'tanggal_berakhir' => $baris['tanggal_berakhir'],
                                                    'guru_id' => $baris['guru_id'],
                                                    'peserta' => []
                                                ];
                                            }

                                            // Tambahkan peserta ke dalam array peserta jadwal tersebut
                                            foreach ($result_peserta as $peserta) {
                                                if ($baris['kelas_id'] == $peserta['kelas_id']) {
                                                    $data[$kelas_id]['peserta'][] = [
                                                        'username' => $peserta['username'],
                                                        'user_id' => $peserta['user_id'],
                                                    ];
                                                }
                                            }
                                        }
                                        foreach ($data as $value) {
                                        ?>
                                            <tr>
                                                <td><?= $value['id'] + 1 ?></td>
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
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-primary btn-sm text-light" data-bs-toggle="modal"
                                                            data-bs-target="#detail_<?= $value['kelas_id'] ?>"><i class="bi bi-eye"></i></button>
                                                    </div>
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
                                                                    <p><b>Pesan</b>: <?= $value['pesan'] ?></p>
                                                                    <p><b>Deskripsi</b>: <?= $value['deskripsi'] ?></p>
                                                                    <br>
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
                </div>
            </section>
        </div>
        <?php include_once("../layout/footer.php") ?>
    </div>
    <?php include_once("../layout/footer-link.php") ?>


</body>

</html>