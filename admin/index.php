<?php
include_once('../config/redirect.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "beranda"; ?>
    <?php include_once("../layout/header-link.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include_once("../layout/sidebar.php") ?>

        <div id="main">
            <?php include_once("../layout/header.php") ?>

            <div class="page-heading">
                <h3>Hallo <b><?= $user['username'] ?>👋</b></h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card border-danger" style="border-right: 5px solid;">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center align-items-center ">
                                                <div class="bg-danger p-2 px-3 fs-3 rounded">
                                                    <i class="bi bi-calendar-day-fill"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 text-center">
                                                <h2 class="font-extrabold mb-0">
                                                    <?= date('d'); ?>
                                                </h2>
                                                <h6 class="font-extrabold mb-0">
                                                    <?= date('l'); ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card border-warning" style="border-right: 5px solid;">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start align-items-center ">
                                                <div class="bg-warning p-2 px-3 fs-3 rounded">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Peserta</h6>
                                                <?php
                                                $sql_peserta = "SELECT COUNT(DISTINCT id) as total_peserta FROM users WHERE role = 'siswa'";
                                                $result_peserta = $conn->query($sql_peserta);
                                                $row_peserta = $result_peserta->fetch_assoc();
                                                $total_peserta = $row_peserta['total_peserta'];
                                                ?>
                                                <h3 class="font-extrabold mb-0" id="waktu_berjalan"><?= $total_peserta ?></h3>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card border-success" style="border-right: 5px solid;">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start align-items-center ">
                                                <div class="bg-success p-2 px-3 fs-3 rounded">
                                                    <i class="bi bi-person-workspace"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Guru</h6>
                                                <?php
                                                $sql_guru = "SELECT COUNT(DISTINCT id) as total_guru FROM users WHERE role = 'guru'";
                                                $result_guru = $conn->query($sql_guru);
                                                $row_guru = $result_guru->fetch_assoc();
                                                $total_guru = $row_guru['total_guru'];
                                                ?>
                                                <h3 class="font-extrabold mb-0" id="waktu_berjalan"><?= $total_guru ?></h3>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card border-primary" style="border-right: 5px solid;">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center align-items-center">
                                                <div class="bg-primary p-2 px-3 fs-3 rounded">
                                                    <i class="bi bi-person-rolodex"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Kelas</h6>
                                                <?php
                                                $user_id = $user['id'];
                                                $sql_classes = "
                                                SELECT COUNT(*) as total_classes 
                                                FROM kelas 
                                            ";
                                                $result_classes = $conn->query($sql_classes);
                                                $row_classes = $result_classes->fetch_assoc();
                                                $total_classes = $row_classes['total_classes'];
                                                ?>
                                                <h4 class="font-extrabold mb-0"><?= $total_classes ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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