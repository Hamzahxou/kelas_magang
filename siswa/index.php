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
                                <div class="card border-danger" style="border-left: 5px solid;border-bottom: 5px solid;">
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
                                <div class="card border-warning" style="border-left: 5px solid;border-bottom: 5px solid;">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start align-items-center ">
                                                <div class="bg-warning p-2 px-3 fs-3 rounded">
                                                    <i class="bi bi-clock-fill"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Waktu</h6>
                                                <h5 class="font-extrabold mb-0" id="waktu_berjalan">19:00:00
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card border-success" style="border-left: 5px solid;border-bottom: 5px solid;">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center align-items-center">
                                                <div class="bg-success p-2 px-3 fs-3 rounded">
                                                    <i class="bi bi-person-rolodex"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Kelas</h6>
                                                <?php
                                                $user_id = $user['id'];
                                                $sql_classes = "
                                                SELECT COUNT(*) as total_classes 
                                                FROM peserta 
                                                WHERE user_id = '$user_id'
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
                            <div class="col-6 col-lg-3 col-md-6">
                                <?php
                                // $tanggal_sekarang = date('Y-m-d');
                                // $sql_kehadiran = "SELECT * FROM kehadiran_peserta WHERE peserta_id = '$peserta_magang[id]' AND tanggal_kehadiran = '$tanggal_sekarang'";
                                // $result_kehadiran = $conn->query($sql_kehadiran);
                                // $row_kehadiran = $result_kehadiran->fetch_assoc();
                                ?>
                                <div class="card border-primary" style="border-left: 5px solid;border-bottom: 5px solid;">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start align-items-center">
                                                <button class="btn btn-light-primary p-2 px-3 fs-3 rounded" data-bs-toggle="modal"
                                                    data-bs-target="#absen">
                                                    <?php
                                                    // echo $row_kehadiran != NULL ? 'disabled' : ''
                                                    ?>
                                                    <i class="bi bi-journal"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">absen</h6>
                                                <h6 class="font-extrabold mb-0" id="waktu_berjalan">
                                                    <?php
                                                    // if ($row_kehadiran != NULL) {
                                                    //     echo "sudah absen";
                                                    // } else {
                                                    //     echo "belum absen";
                                                    // }
                                                    echo "absen"
                                                    ?>
                                                </h6>
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

    <!-- start absen-->
    <div class="modal fade" id="absen" tabindex="-1" role="dialog"
        aria-labelledby="absenTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="absenTitle">Mulai Absen</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>

                <?php
                $sql = "SELECT jadwal.*, kelas.*,peserta.*,users.id FROM jadwal
                  INNER JOIN kelas ON jadwal.kelas_id = kelas.id
                  INNER JOIN peserta ON kelas.id = peserta.kelas_id
                  INNER JOIN users ON peserta.user_id = users.id
                  WHERE user_id = '$user_id'
                  ";

                $result = $conn->query($sql);
                ?>
                <form action='<?= $url . "/config/siswa/absen.php" ?>' method="post">
                    <input type="hidden" name="peserta_id" value="<?= $peserta_magang['id'] ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="kelas">Kelas</label>
                                <select name="kelas" id="kelas" class="form-select">
                                    <option value="" selected disabled>Pilih Kelas</option>
                                    <?php
                                    foreach ($result as $value) {
                                        if ($value['tanggal_mulai'] <=  date('Y-m-d') && $value['tanggal_berakhir'] >=  date('Y-m-d')) {
                                    ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['nama_kelas'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="" selected disabled>Status kehadiran</option>
                                    <option value="hadir">Hadir</option>
                                    <option value="absen">Tidak Hadir</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bi bi-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">tutup</span>
                        </button>
                        <button type="submit" name="absen" class="btn btn-light-primary">
                            <i class="bi bi-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">kirim</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end absen-->

    <?php include_once("../layout/footer-link.php") ?>
    <script>
        function waktu() {
            const waktu_berjalan = document.getElementById("waktu_berjalan");
            let waktu = new Date();
            let jam = waktu.getHours();
            let menit = waktu.getMinutes();
            let detik = waktu.getSeconds();
            waktu_berjalan.innerHTML = jam.toString().padStart(2, '0') + ":" + menit.toString().padStart(2, '0') + ":" + detik.toString().padStart(2, '0');
        }
        waktu()
        setInterval(waktu, 50);
    </script>

</body>

</html>