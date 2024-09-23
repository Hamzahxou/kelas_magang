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
            <a href="<?= $url . '/' . $user['role'] . '/users.php' ?>" class="btn btn-light-primary "><i class="bi bi-arrow-left"></i> Kembali</a>
            <!-- <a href="<?= parse_url($_SERVER['HTTP_REFERER'])['path'] == $_SERVER['REQUEST_URI']  ? $url . '/' . $hasil_user['role'] : $_SERVER['HTTP_REFERER'] ?>" class="btn btn-light-primary "><i class="bi bi-arrow-left"></i> Kembali</a> -->

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

                <?php if ($role == 'siswa') { ?>
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
                <?php } else if ($role == 'guru') { ?>
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
                                        // print_r($result->fetch_assoc());

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
                                                        <button class="btn btn-warning btn-sm text-light" data-bs-toggle="modal"
                                                            data-bs-target="#edit_<?= $value['kelas_id'] ?>"><i class="bi bi-pencil-square"></i></button>
                                                        <button class="btn btn-secondary btn-sm text-light" data-bs-toggle="modal"
                                                            data-bs-target="#edit_peserta_<?= $value['kelas_id'] ?>"><i class="bi bi-people"></i></button>
                                                        <button class="btn btn-danger btn-sm text-light" data-bs-toggle="modal"
                                                            data-bs-target="#hapus_kelas_<?= $value['kelas_id'] ?>"><i class="bi bi-trash2"></i></button>
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
                                                                    <small>Guru / Pembimbing :
                                                                        <a href="<?= $url . "/admin/profile.php?user=" . $value['guru_id'] . "&role=guru" ?>"><?= $value['username'] ?></a>
                                                                    </small>
                                                                    <hr>
                                                                    <p><b>Pesan</b>: <?= $value['pesan'] ?></p>
                                                                    <p><b>Deskripsi</b>: <?= $value['deskripsi'] ?></p>
                                                                    <br>
                                                                    <b>peserta: <?= count($value['peserta'])  ?></b>
                                                                    <ul>
                                                                        <?php
                                                                        foreach ($value['peserta'] as $index_peserta => $peserta) {
                                                                        ?>
                                                                            <li> <a href="<?= $url . "/admin/profile.php?user=" . $peserta['user_id'] . "&role=siswa" ?>"><?= $peserta['username'] ?></a>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
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
                                                    <!-- start edit kelas -->
                                                    <div class="modal fade" id="edit_<?= $value['kelas_id'] ?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="edit_<?= $value['kelas_id'] ?>Title" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="edit_<?= $value['kelas_id'] ?>Title">Edit Kelas</h5>
                                                                    <button type="button" class="btn" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </div>
                                                                <form action='<?= $url . "/config/admin/kelas.php" ?>' method="post">
                                                                    <input type="hidden" name="kelas_id" value="<?= $value['kelas_id'] ?>">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="nama_kelas_<?= $value['kelas_id'] ?>">Nama Kelas</label>
                                                                                    <input type="text" id="nama_kelas_<?= $value['kelas_id'] ?>" class="form-control"
                                                                                        placeholder="Nama Kelas" name="nama_kelas" value="<?= $value['nama_kelas'] ?>">
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="tanggal_mulai_<?= $value['kelas_id'] ?>">Tanggal Mulai</label>
                                                                                    <input type="date" id="tanggal_mulai_<?= $value['kelas_id'] ?>" class="form-control"
                                                                                        placeholder="Tanggal Mulai" name="tanggal_mulai" value="<?= $value['tanggal_mulai'] ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="tanggal_berakhir_<?= $value['kelas_id'] ?>">Tanggal berakhir</label>
                                                                                    <input type="date" id="tanggal_berakhir_<?= $value['kelas_id'] ?>" class="form-control"
                                                                                        placeholder="Tanggal berakhi" name="tanggal_berakhir" value="<?= $value['tanggal_berakhir'] ?>">
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="waktu_mulai_<?= $value['kelas_id'] ?>">Waktu Mulai</label>
                                                                                    <input type="time" id="waktu_mulai_<?= $value['kelas_id'] ?>" class="form-control"
                                                                                        placeholder="Waktu Mulai" name="waktu_mulai" value="<?= $value['waktu_mulai'] ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="waktu_selesai_<?= $value['kelas_id'] ?>">Waktu Selesai</label>
                                                                                    <input type="time" id="waktu_selesai_<?= $value['kelas_id'] ?>" class="form-control"
                                                                                        placeholder="Waktu Selesai" name="waktu_selesai" value="<?= $value['waktu_selesai'] ?>">
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="pesan_<?= $value['kelas_id'] ?>">Pesan</label>
                                                                                    <textarea name="pesan" class="form-control" id="pesan_<?= $value['kelas_id'] ?>" rows="3"><?= $value['pesan'] ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="deskripsi_<?= $value['kelas_id'] ?>">Deskripsi</label>
                                                                                    <textarea name="deskripsi" class="form-control" id="deskripsi_<?= $value['kelas_id'] ?>" rows="3"><?= $value['deskripsi'] ?></textarea>
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
                                                                        <button type="submit" name="edit_kelas" class="btn btn-light-primary">
                                                                            <i class="bi bi-check d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">simpan</span>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end edit kelas -->
                                                    <!-- start edit peserta -->
                                                    <div class="modal fade" id="edit_peserta_<?= $value['kelas_id'] ?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="edit_peserta_<?= $value['kelas_id'] ?>Title" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="edit_peserta_<?= $value['kelas_id'] ?>Title">Edit Peserta Kelas</h5>
                                                                    <button type="button" class="btn" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                                                        <li class="nav-item" role="presentation">
                                                                            <a class="nav-link active" id="tambah-peserta-<?= $value['kelas_id'] ?>-tab" data-bs-toggle="tab" href="#tambah-peserta-<?= $value['kelas_id'] ?>" role="tab"
                                                                                aria-controls="tambah-peserta-<?= $value['kelas_id'] ?>" aria-selected="true">Tambahkan</a>
                                                                        </li>
                                                                        <li class="nav-item" role="presentation">
                                                                            <a class="nav-link" id="keluarkan-peserta-<?= $value['kelas_id'] ?>-tab" data-bs-toggle="tab" href="#keluarkan-peserta-<?= $value['kelas_id'] ?>" role="tab"
                                                                                aria-controls="keluarkan-peserta-<?= $value['kelas_id'] ?>" aria-selected="false">Keluarkan</a>
                                                                        </li>
                                                                    </ul>
                                                                    <div class="tab-content" id="myTabContent">
                                                                        <div class="tab-pane fade show active" id="tambah-peserta-<?= $value['kelas_id'] ?>" role="tabpanel" aria-labelledby="tambah-peserta-<?= $value['kelas_id'] ?>-tab">
                                                                            <form action='<?= $url . "/config/admin/kelas.php" ?>' method="post">
                                                                                <input type="hidden" name="kelas_id" value="<?= $value['kelas_id'] ?>">
                                                                                <div class="row">
                                                                                    <div class="col-12 mb-3">
                                                                                        <div class='form-check'>
                                                                                            <?php
                                                                                            foreach ($data_peserta as $i => $peserta) {
                                                                                                if (!in_array($peserta['username'], array_column($value['peserta'], 'username'))) {
                                                                                            ?>
                                                                                                    <div class="checkbox">
                                                                                                        <input type="checkbox" name="peserta[]" id="peserta_<?= $value['kelas_id'] ?>_<?= $i ?>" value="<?= $peserta['id'] ?>" class="form-check-input">
                                                                                                        <label for="peserta_<?= $value['kelas_id'] ?>_<?= $i ?>"><?= $peserta['username'] ?></label>
                                                                                                    </div>
                                                                                            <?php }
                                                                                            } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12 d-flex justify-content-end">
                                                                                        <button type="submit" name="tambahkan_peserta" class="btn btn-light-primary">
                                                                                            <i class="bi bi-check d-block d-sm-none"></i>
                                                                                            <span class="d-none d-sm-block">tambahkan</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="keluarkan-peserta-<?= $value['kelas_id'] ?>" role="tabpanel" aria-labelledby="keluarkan-peserta-<?= $value['kelas_id'] ?>-tab">
                                                                            <form action='<?= $url . "/config/admin/kelas.php" ?>' method="post">
                                                                                <input type="hidden" name="kelas_id" value="<?= $value['kelas_id'] ?>">
                                                                                <div class="row">
                                                                                    <div class="col-12 mb-3">
                                                                                        <div class='form-check'>
                                                                                            <?php
                                                                                            foreach ($data_peserta as $i => $peserta) {
                                                                                                if (in_array($peserta['username'], array_column($value['peserta'], 'username'))) {
                                                                                            ?>
                                                                                                    <div class="checkbox">
                                                                                                        <input type="checkbox" name="peserta[]" id="peserta_<?= $value['kelas_id'] ?>_<?= $i ?>" value="<?= $peserta['id'] ?>" class="form-check-input">
                                                                                                        <label for="peserta_<?= $value['kelas_id'] ?>_<?= $i ?>"><?= $peserta['username'] ?></label>
                                                                                                    </div>
                                                                                            <?php }
                                                                                            } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12 d-flex justify-content-end">
                                                                                        <button type="submit" name="keluarkan_peserta" class="btn btn-light-primary">
                                                                                            <i class="bi bi-check d-block d-sm-none"></i>
                                                                                            <span class="d-none d-sm-block">keluarkan</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
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
                                                    <!-- end edit peserta -->
                                                    <!-- start hapus kelas -->
                                                    <div class="modal fade" id="hapus_kelas_<?= $value['kelas_id'] ?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="hapus_kelas_<?= $value['kelas_id'] ?>Title" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="hapus_kelas_<?= $value['kelas_id'] ?>Title">Hapus Kelas</h5>
                                                                    <button type="button" class="btn" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h6>Yakin ingin menghapus kelas <b><?= $value['nama_kelas'] ?></b>?</h6>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light-secondary"
                                                                        data-bs-dismiss="modal">
                                                                        <i class="bi bi-x d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">tutup</span>
                                                                    </button>
                                                                    <form action='<?= $url . "/config/admin/kelas.php" ?>' method="post">
                                                                        <input type="hidden" name="kelas_id" value="<?= $value['kelas_id'] ?>">
                                                                        <button type="submit" name="hapus_kelas" class="btn btn-light-danger">
                                                                            <i class="bi bi-check d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">lanjut</span>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end hapus kelas -->
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
                <?php } ?>
            </section>
        </div>
        <?php include_once("../layout/footer.php") ?>
    </div>
    <?php include_once("../layout/footer-link.php") ?>


</body>

</html>