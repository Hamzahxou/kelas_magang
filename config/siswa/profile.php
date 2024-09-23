<?php
include_once('../database.php');
if (isset($_POST['edit'])) {
    $user_id = $_POST['user_id'];
    $detail_user_id = $_POST['detail_user_id'];
    $username = $_POST['username'];
    $nisn = $_POST['nisn'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $sql_user = "UPDATE users SET username = '$username' WHERE id = '$user_id'";
    mysqli_query($conn, $sql_user);
    $sql_peserta = "UPDATE detail_peserta SET nisn = '$nisn', no_telp = '$no_telp', alamat = '$alamat' WHERE id = '$detail_user_id'";
    mysqli_query($conn, $sql_peserta);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'Profile berhasil diubah'
    ];
    header("location: " . $url . "/siswa/profile.php");
}
