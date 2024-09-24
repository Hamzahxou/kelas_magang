<?php
include_once('../database.php');
if (isset($_POST['edit'])) {
    $user_id = $_POST['user_id'];
    $detail_user_id = $_POST['detail_user_id'];
    $username = $_POST['username'];
    $nip = $_POST['nip'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $foto_profile_db = $_POST['foto_profile_db'];
    $foto_profile = $_FILES['foto_profile']['name'];
    $avatar = $foto_profile_db;


    $sql_cek_detail = "SELECT * FROM detail_guru WHERE (nip = '$nip' OR no_telp = '$no_telp') AND id != '$detail_user_id'";
    $cek_detail = mysqli_query($conn, $sql_cek_detail);
    $cek_detail = $cek_detail->fetch_assoc();
    if ($cek_detail['nip'] == $nip) {
        $_SESSION['flash_alert'] = [
            'type' => 'danger',
            'pesan' => 'Nip sudah ada'
        ];
        header("location: " . $url . "/guru/profile.php");
        die();
    } elseif ($cek_detail['no_telp'] == $no_telp) {
        $_SESSION['flash_alert'] = [
            'type' => 'danger',
            'pesan' => 'No Telp sudah ada'
        ];
        header("location: " . $url . "/guru/profile.php");
        die();
    }


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
    $sql_guru = "UPDATE detail_guru SET nip = '$nip', no_telp = '$no_telp', alamat = '$alamat', avatar = '$avatar' WHERE id = '$detail_user_id'";
    mysqli_query($conn, $sql_guru);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'Profile berhasil diubah'
    ];
    header("location: " . $url . "/guru/profile.php");
}
