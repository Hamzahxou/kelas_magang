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
                <h3>info kehadiran</h3>
            </div>
            <div class="page-content">
                <?php include_once('../layout/flash_alert.php') ?>
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kelas</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $user_id = $user['id'];
                                        $sql = "SELECT * FROM kehadiran_peserta
                                        INNER JOIN peserta ON kehadiran_peserta.peserta_id = peserta.id
                                        INNER JOIN kelas ON peserta.kelas_id = kelas.id
                                        INNER JOIN users ON peserta.user_id = users.id
                                        WHERE user_id = '$user_id'
                                        ";

                                        $result = $conn->query($sql);
                                        echo "<h2>Jadwal Kelas Anda</h2>";
                                        foreach ($result as $index => $value) {
                                        ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= $value['nama_kelas'] ?></td>
                                                <td><?= $value['tanggal_kehadiran'] ?></td>
                                                <td><?= $value['status'] == "hadir" ? "<span class='badge bg-light-success'>hadir</span>" : "<span class='badge bg-light-danger'>tidak hadir</span>" ?></td>

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