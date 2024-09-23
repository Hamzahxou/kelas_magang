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
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6>Jadwal Kelas Anda</h6>
                                <form action="" method="get" class="mb-3">
                                    <div class="d-flex gap-1">
                                        <input type="text" class="form-control" name="cari" placeholder="cari kelas" value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
                                        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                                    </div>
                                </form>
                                <hr>
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
                                        $user_id = $user['id'];
                                        if (isset($_GET['cari'])) {
                                            $cari = $_GET['cari'];
                                            $sql = "SELECT jadwal.*, kelas.*,peserta.*,users.id FROM jadwal
                                        INNER JOIN kelas ON jadwal.kelas_id = kelas.id
                                        INNER JOIN peserta ON kelas.id = peserta.kelas_id
                                        INNER JOIN users ON peserta.user_id = users.id
                                        WHERE user_id = '$user_id' AND nama_kelas LIKE '%$cari%'
                                        ";
                                        } else {
                                            $sql = "SELECT jadwal.*, kelas.*,peserta.*,users.id FROM jadwal
                                        INNER JOIN kelas ON jadwal.kelas_id = kelas.id
                                        INNER JOIN peserta ON kelas.id = peserta.kelas_id
                                        INNER JOIN users ON peserta.user_id = users.id
                                        WHERE user_id = '$user_id'
                                        ";
                                        }

                                        $result = $conn->query($sql);

                                        $cari_guru = "SELECT id,username FROM users WHERE role = 'guru'";
                                        $result_guru = $conn->query($cari_guru);
                                        $data_guru = [];
                                        foreach ($result_guru as $guru) {
                                            $data_guru[] = $guru;
                                        }

                                        $data_teman = "SELECT kelas_id,username,user_id FROM kelas 
                                        JOIN peserta ON kelas.id = peserta.kelas_id
                                        JOIN users ON peserta.user_id = users.id
                                        WHERE user_id != '$user_id'
                                         ";
                                        $result_teman = $conn->query($data_teman);
                                        $data_teman = [];
                                        foreach ($result_teman as $teman) {
                                            $data_teman[] = $teman;
                                        }
                                        foreach ($result as $index => $value) {
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
                                                                    <hr>
                                                                    <b>teman: </b>
                                                                    <ul>
                                                                        <?php
                                                                        if (count($data_teman) > 0) {
                                                                            foreach ($data_teman as  $teman) {
                                                                                if ($value['kelas_id'] == $teman['kelas_id']) {
                                                                        ?>
                                                                                    <a href="<?= $url . "/siswa/detail-teman.php?user=" . $teman['user_id'] . "&role=siswa" ?>"><?= $teman['username'] ?></a>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        } else {
                                                                            echo "<li>Tidak ada teman</li>";
                                                                        }
                                                                        ?>
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
    </div>
    <?php include_once("../layout/footer-link.php") ?>


</body>

</html>