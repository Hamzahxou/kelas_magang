<?php
include_once('../database.php');
if (isset($_POST['absen'])) {
    if (isset($_POST['kelas']) && isset($_POST['status'])) {
        $peserta_id = $_POST['peserta_id'];
        $kelas = $_POST['kelas'];
        $status = $_POST['status'];
        $tanggal_sekarang = date('Y-m-d');
        $sql = "INSERT INTO kehadiran_peserta (peserta_id, jadwal_id, status, tanggal_kehadiran) VALUES ('$peserta_id', '$kelas', '$status', '$tanggal_sekarang')";
        mysqli_query($conn, $sql);
        $_SESSION['flash_alert'] = [
            'type' => 'success',
            'pesan' => 'absen berhasil ditambahkan'
        ];
    }
    header("location: " . $url . "/siswa/kehadiran.php");
}
