<?php
include_once('../database.php');
if (isset($_POST['edit'])) {
    $user_id = $_POST['user_id'];
    $detail_user_id = $_POST['detail_user_id'];
    $username = $_POST['username'];
    $nisn = $_POST['nisn'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $foto_profile_db = $_POST['foto_profile_db'];
    $foto_profile = $_FILES['foto_profile']['name'];
    $avatar = $foto_profile_db;
    if ($foto_profile) {
        $extension = explode('.', $foto_profile);
        $extension = end($extension);
        $filename = date('Y-m-d-H-i-s') . token(5);
        $filename .= '.' . $extension;
        $target_paths = '../../assets/static/images/faces/';
        $file_tmp = $_FILES['foto_profile']['tmp_name'];
        $target_path = $target_paths . $filename;
        $cek =  move_uploaded_file($file_tmp, $target_path);
        unlink($target_paths . $foto_profile_db);
        $avatar = $filename;
    }
    $sql_user = "UPDATE users SET username = '$username' WHERE id = '$user_id'";
    mysqli_query($conn, $sql_user);
    $sql_peserta = "UPDATE detail_peserta SET nisn = '$nisn', no_telp = '$no_telp', alamat = '$alamat', avatar = '$avatar' WHERE id = '$detail_user_id'";
    mysqli_query($conn, $sql_peserta);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'Profile berhasil diubah'
    ];
    header("location: " . $url . "/siswa/profile.php");
}
