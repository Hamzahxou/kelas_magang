<?php
include_once('../config/redirect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "kelas"; ?>
    <?php include_once("../layout/header-link.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include_once("../layout/sidebar.php") ?>

        <div id="main">
            <?php include_once("../layout/header.php") ?>


            <div class="page-heading">
                <h3>info kelas</h3>
            </div>
            <div class="page-content">
                <?php include_once("../layout/flash_alert.php") ?>
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4>jadwal kelas</h4>
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#tambah_kelas">tambah kelas</button>
                                </div>
                                <form action="" method="get" class="mb-3">
                                    <div class="d-flex gap-1">
                                        <input type="text" class="form-control" name="cari" placeholder="cari kelas" value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
                                        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                                    </div>
                                </form>
                                <hr>
                                <!-- start tambah kelas -->
                                <div class="modal fade" id="tambah_kelas" tabindex="-1" role="dialog"
                                    aria-labelledby="tambah_kelasTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="tambah_kelasTitle">Tambah Kelas</h5>
                                                <button type="button" class="btn" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <form action='<?= $url . "/config/guru/kelas.php" ?>' method="post">
                                                <input type="hidden" name="guru_id" value="<?= $user['id'] ?>">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="nama_kelas">Nama Kelas</label>
                                                                <input type="text" id="nama_kelas" class="form-control"
                                                                    placeholder="Nama Kelas" name="nama_kelas">
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                                                <input type="date" id="tanggal_mulai" class="form-control"
                                                                    placeholder="Tanggal Mulai</label>" name="tanggal_mulai">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="tanggal_berakhir">Tanggal berakhir</label>
                                                                <input type="date" id="tanggal_berakhir" class="form-control"
                                                                    placeholder="Tanggal berakhir</label>" name="tanggal_berakhir">
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="waktu_mulai">Waktu Mulai</label>
                                                                <input type="time" id="waktu_mulai" class="form-control"
                                                                    placeholder="Waktu Mulai" name="waktu_mulai">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="waktu_selesai">Waktu Selesai</label>
                                                                <input type="time" id="waktu_selesai" class="form-control"
                                                                    placeholder="Waktu Selesai" name="waktu_selesai">
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="pesan">Pesan</label>
                                                                <textarea name="pesan" class="form-control" id="pesan" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="deskripsi">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3"></textarea>
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
                                                    <button type="submit" name="tambah_kelas" class="btn btn-light-primary">
                                                        <i class="bi bi-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">simpan</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tambah kelas -->
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

                                        $user_id = $user['id'];
                                        if (isset($_GET['cari'])) {
                                            $cari = $_GET['cari'];
                                            $sql = "SELECT * FROM jadwal
                                        LEFT JOIN kelas ON jadwal.kelas_id = kelas.id
                                        WHERE guru_id = '$user_id' AND nama_kelas LIKE '%$cari%'; ";
                                        } else {
                                            $sql = "SELECT * FROM jadwal
                                        LEFT JOIN kelas ON jadwal.kelas_id = kelas.id
                                        WHERE guru_id = '$user_id'
                                        ";
                                        }
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
                                                    'token' => $baris['token'],
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
                                                                    <p><?= $value['pesan'] ?></p>
                                                                    <p><?= $value['deskripsi'] ?></p>
                                                                    <br>
                                                                    <b>peserta: <?= count($value['peserta'])  ?></b>
                                                                    <ul>
                                                                        <?php
                                                                        foreach ($value['peserta'] as $index_peserta => $peserta) {
                                                                        ?>
                                                                            <li> <a href="<?= $url . "/guru/detail-peserta.php?user=" . $peserta['user_id'] . "&role=siswa" ?>"><?= $peserta['username'] ?></a>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-between align-items-center">
                                                                    <b>Token : <?= $value['token'] ?></b>
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
                                                                <form action='<?= $url . "/config/guru/kelas.php" ?>' method="post">
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
                                                                                        placeholder="Tanggal berakhirr" name="tanggal_berakhir" value="<?= $value['tanggal_berakhir'] ?>">
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
                                                                            <form action='<?= $url . "/config/guru/kelas.php" ?>' method="post">
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
                                                                            <form action='<?= $url . "/config/guru/kelas.php" ?>' method="post">
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
                                                                    <form action='<?= $url . "/config/guru/kelas.php" ?>' method="post">
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
                </section>
            </div>
            <?php include_once("../layout/footer.php") ?>
        </div>
    </div>
    <?php include_once("../layout/footer-link.php") ?>


</body>

</html>