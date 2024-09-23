<?php
include_once('../database.php');
if (isset($_POST['edit'])) {
    $user_id = $_POST['user_id'];
    $detail_user_id = $_POST['detail_user_id'];
    $username = $_POST['username'];
    $nip = $_POST['nip'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $sql_user = "UPDATE users SET username = '$username' WHERE id = '$user_id'";
    mysqli_query($conn, $sql_user);
    $sql_guru = "UPDATE detail_guru SET nip = '$nip', no_telp = '$no_telp', alamat = '$alamat' WHERE id = '$detail_user_id'";
    mysqli_query($conn, $sql_guru);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'Profile berhasil diubah'
    ];
    header("location: " . $url . "/guru/profile.php");
}
