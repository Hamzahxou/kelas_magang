<?php
include_once('../database.php');
$token = $_POST['token'];
$cari_kelas = "SELECT * FROM kelas WHERE token = '$token'";
$kelas = $conn->query($cari_kelas);
$kelas = $kelas->fetch_assoc();
if ($kelas) {
    $kelas_id = $kelas['id'];
    $user_id = $_POST['user_id'];
    $cari_peserta_kelas = "SELECT user_id FROM peserta WHERE user_id = '$user_id' AND kelas_id = '$kelas_id'";
    $peserta_kelas = $conn->query($cari_peserta_kelas);
    $peserta_kelas = $peserta_kelas->fetch_assoc();
    if (!$peserta_kelas) {
        $sql_peserta = "INSERT INTO peserta (kelas_id, user_id, tanggal_daftar) VALUES ('$kelas_id', '$user_id', NOW())";
        mysqli_query($conn, $sql_peserta);

        $_SESSION['flash_alert'] = [
            'type' => 'success',
            'pesan' => 'Berhasil masuk kelas'
        ];
    } else {
        $_SESSION['flash_alert'] = [
            'type' => 'warning',
            'pesan' => 'kamu sudah masuk kelas ini'
        ];
    }
} else {
    $_SESSION['flash_alert'] = [
        'type' => 'danger',
        'pesan' => 'tidak ada token yang cocok'
    ];
}
header("location: " . $url . "/siswa/kelas.php");
