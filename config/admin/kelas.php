<?php
include_once('../database.php');
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
            'pesan' => 'peserta berhasil dikeluarkan'
        ];
    }
    header("location: " . $url . "/admin/kelas.php");
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
            'pesan' => 'peserta berhasil ditambahkan'
        ];
    }
    header("location: " . $url . "/admin/kelas.php");
}


if (isset($_POST['edit_kelas'])) {
    $kelas_id = $_POST['kelas_id'];
    $nama_kelas = $_POST['nama_kelas'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_berakhir = $_POST['tanggal_berakhir'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $pesan = $_POST['pesan'];
    $deskripsi = $_POST['deskripsi'];
    $sql_kelas = "UPDATE kelas SET nama_kelas = '$nama_kelas', tanggal_mulai = '$tanggal_mulai', tanggal_berakhir = '$tanggal_berakhir', deskripsi = '$deskripsi' WHERE id = '$kelas_id'";
    $hasil = mysqli_query($conn, $sql_kelas);
    $sql_jadwal = "UPDATE jadwal SET waktu_mulai = '$waktu_mulai', waktu_selesai = '$waktu_selesai', pesan = '$pesan' WHERE kelas_id = '$kelas_id'";
    mysqli_query($conn, $sql_jadwal);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'kelas berhasil diubah'
    ];
    header("location: " . $url . "/admin/kelas.php");
}


if (isset($_POST['hapus_kelas'])) {
    $kelas_id = $_POST['kelas_id'];
    $sql_kelas = "DELETE FROM kelas WHERE id = '$kelas_id'";
    mysqli_query($conn, $sql_kelas);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'kelas berhasil dihapus'
    ];
    header("location: " . $url . "/admin/kelas.php");
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
    $sql_kelas = "INSERT INTO kelas (guru_id, nama_kelas, tanggal_mulai, tanggal_berakhir, deskripsi) VALUES ('$guru_id', '$nama_kelas', '$tanggal_mulai', '$tanggal_berakhir', '$deskripsi')";
    $hasil = mysqli_query($conn, $sql_kelas);
    $kelas_id = mysqli_insert_id($conn);
    $sql_jadwal = "INSERT INTO jadwal (waktu_mulai, waktu_selesai, pesan, kelas_id) VALUES ('$waktu_mulai', '$waktu_selesai', '$pesan', '$kelas_id')";
    mysqli_query($conn, $sql_jadwal);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'kelas berhasil dibuat'
    ];
    header("location: " . $url . "/admin/kelas.php");
}
