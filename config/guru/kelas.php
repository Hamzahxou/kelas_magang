<?php
include_once('../database.php');
if (isset($_POST['edit_kelas'])) {
    $kelas_id = $_POST['kelas_id'];
    $nama_kelas = $_POST['nama_kelas'];
    $tanggal_mulai = new DateTime($_POST['tanggal_mulai']);
    $tanggal_berakhir = new DateTime($_POST['tanggal_berakhir']);
    $waktu_mulai = new DateTime($_POST['waktu_mulai']);
    $waktu_selesai = new DateTime($_POST['waktu_selesai']);
    $pesan = $_POST['pesan'];
    $deskripsi = $_POST['deskripsi'];
    $cek_kelas = "SELECT * FROM kelas WHERE nama_kelas = '$nama_kelas' AND id != '$kelas_id'";
    $cek_kelas = mysqli_query($conn, $cek_kelas);
    $cek_kelas = $cek_kelas->fetch_assoc();
    if ($cek_kelas['nama_kelas'] == $nama_kelas) {
        $_SESSION['flash_alert'] = [
            'type' => 'danger',
            'pesan' => 'kelas sudah ada'
        ];
    } elseif ($tanggal_berakhir <= $tanggal_mulai) {
        $_SESSION['flash_alert'] = [
            'type' => 'danger',
            'pesan' => 'tanggal tidak valid'
        ];
    } elseif ($waktu_selesai <= $waktu_mulai) {
        $_SESSION['flash_alert'] = [
            'type' => 'danger',
            'pesan' => 'waktu tidak valid'
        ];
    } else {
        $tanggal_mulai = $tanggal_mulai->format('Y-m-d');
        $tanggal_berakhir = $tanggal_berakhir->format('Y-m-d');
        $waktu_mulai = $waktu_mulai->format('H:i:s');
        $waktu_selesai = $waktu_selesai->format('H:i:s');
        $sql_kelas = "UPDATE kelas SET nama_kelas = '$nama_kelas', tanggal_mulai = '$tanggal_mulai', tanggal_berakhir = '$tanggal_berakhir', deskripsi = '$deskripsi' WHERE id = '$kelas_id'";
        $hasil = mysqli_query($conn, $sql_kelas);
        $sql_jadwal = "UPDATE jadwal SET waktu_mulai = '$waktu_mulai', waktu_selesai = '$waktu_selesai', pesan = '$pesan' WHERE kelas_id = '$kelas_id'";
        mysqli_query($conn, $sql_jadwal);
        $_SESSION['flash_alert'] = [
            'type' => 'success',
            'pesan' => 'kelas berhasil diubah'
        ];
    }
    header("location: " . $url . "/guru/kelas.php");
}

if (isset($_POST['keluarkan_peserta'])) {
    $kelas_id = $_POST['kelas_id'];
    $peserta = $_POST['peserta'];
    if (is_array($peserta)) {
        foreach ($peserta as $user_id) {
            $sql_peserta = "DELETE FROM peserta WHERE kelas_id = '$kelas_id' AND user_id = '$user_id'";
            mysqli_query($conn, $sql_peserta);
        }
        $_SESSION['flash_alert'] = [
            'type' => 'success',
            'pesan' => 'User berhasil dikeluarkan'
        ];
    }
    header("location: " . $url . "/guru/kelas.php");
}
if (isset($_POST['tambahkan_peserta'])) {
    $kelas_id = $_POST['kelas_id'];
    $peserta = $_POST['peserta'];
    $cari_peserta_kelas = "SELECT user_id FROM peserta WHERE kelas_id = '$kelas_id'";
    $peserta_kelas = $conn->query($cari_peserta_kelas);
    $peserta_kelas = [];
    foreach ($peserta_kelas as $peserta) {
        $peserta_kelas[] = $peserta['user_id'];
    }
    if (is_array($peserta)) {
        foreach ($peserta as $user_id) {
            if (!in_array($user_id, $peserta_kelas)) {
                $sql_peserta = "INSERT INTO peserta (kelas_id, user_id, tanggal_daftar) VALUES ('$kelas_id', '$user_id', NOW())";
                mysqli_query($conn, $sql_peserta);
            }
        }
        $_SESSION['flash_alert'] = [
            'type' => 'success',
            'pesan' => 'User berhasil ditambahkan'
        ];
    }
    header("location: " . $url . "/guru/kelas.php");
}

if (isset($_POST['tambah_kelas'])) {
    $guru_id = $_POST['guru_id'];
    $nama_kelas = $_POST['nama_kelas'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_berakhir = $_POST['tanggal_berakhir'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $pesan = $_POST['pesan'];
    $deskripsi = $_POST['deskripsi'];
    $token = token(5);
    $cek_kelas = "SELECT * FROM kelas WHERE guru_id = '$guru_id' AND nama_kelas = '$nama_kelas'";
    $cek_kelas = mysqli_query($conn, $cek_kelas);
    if (mysqli_num_rows($cek_kelas) > 0) {
        $_SESSION['flash_alert'] = [
            'type' => 'danger',
            'pesan' => 'kelas sudah ada'
        ];
    } elseif ($tanggal_berakhir <= $tanggal_mulai) {
        $_SESSION['flash_alert'] = [
            'type' => 'danger',
            'pesan' => 'tanggal tidak valid'
        ];
    } elseif ($waktu_selesai <= $waktu_mulai) {
        $_SESSION['flash_alert'] = [
            'type' => 'danger',
            'pesan' => 'waktu tidak valid'
        ];
    } else {
        $sql_kelas = "INSERT INTO kelas (guru_id, nama_kelas, tanggal_mulai, tanggal_berakhir, deskripsi, token) VALUES ('$guru_id', '$nama_kelas', '$tanggal_mulai', '$tanggal_berakhir', '$deskripsi', '$token')";
        $hasil = mysqli_query($conn, $sql_kelas);
        $kelas_id = mysqli_insert_id($conn);
        $sql_jadwal = "INSERT INTO jadwal (waktu_mulai, waktu_selesai, pesan, kelas_id) VALUES ('$waktu_mulai', '$waktu_selesai', '$pesan', '$kelas_id')";
        mysqli_query($conn, $sql_jadwal);
        $_SESSION['flash_alert'] = [
            'type' => 'success',
            'pesan' => 'kelas berhasil dibuat'
        ];
    }
    header("location: " . $url . "/guru/kelas.php");
}

if (isset($_POST['hapus_kelas'])) {
    $kelas_id = $_POST['kelas_id'];
    $sql_kelas = "DELETE FROM kelas WHERE id = '$kelas_id'";
    mysqli_query($conn, $sql_kelas);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'kelas berhasil dihapus'
    ];
    header("location: " . $url . "/guru/kelas.php");
}
