<?php
include_once('../database.php');
if (isset($_POST['edit'])) {
    $user_id = $_POST['user_id'];
    $detail_user_id = $_POST['detail_user_id'];
    $username = $_POST['username'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $sql_user = "UPDATE users SET username = '$username' WHERE id = '$user_id'";
    mysqli_query($conn, $sql_user);
    if ($_POST['role'] == 'guru') {
        $nip = $_POST['nip'];

        $sql_cek_detail = "SELECT * FROM detail_guru WHERE( nip = '$nip' OR no_telp = '$no_telp') AND id != '$detail_user_id'";
        $cek_detail = mysqli_query($conn, $sql_cek_detail);
        $cek_detail = $cek_detail->fetch_assoc();
        if ($cek_detail['nip'] == $nip) {
            $_SESSION['flash_alert'] = [
                'type' => 'danger',
                'pesan' => 'Nip sudah ada'
            ];
            header("location: " . $url . "/admin/profile.php?user=" . $user_id . "&role=" . $_POST['role']);
            die();
        } elseif ($cek_detail['no_telp'] == $no_telp) {
            $_SESSION['flash_alert'] = [
                'type' => 'danger',
                'pesan' => 'No Telp sudah ada'
            ];
            header("location: " . $url . "/admin/profile.php?user=" . $user_id . "&role=" . $_POST['role']);
            die();
        }

        $sql_detail = "UPDATE detail_guru SET nip = '$nip', no_telp = '$no_telp', alamat = '$alamat' WHERE id = '$detail_user_id'";
    } else if ($_POST['role'] == 'siswa') {
        $nisn = $_POST['nisn'];
        $sql_cek_detail = "SELECT * FROM detail_peserta WHERE( nisn = '$nisn' OR no_telp = '$no_telp') AND id != '$detail_user_id'";
        $cek_detail = mysqli_query($conn, $sql_cek_detail);
        $cek_detail = $cek_detail->fetch_assoc();
        if ($cek_detail['nisn'] == $nisn) {
            $_SESSION['flash_alert'] = [
                'type' => 'danger',
                'pesan' => 'Nisn sudah ada'
            ];
            header("location: " . $url . "/admin/profile.php?user=" . $user_id . "&role=" . $_POST['role']);
            die();
        } elseif ($cek_detail['no_telp'] == $no_telp) {
            $_SESSION['flash_alert'] = [
                'type' => 'danger',
                'pesan' => 'No Telp sudah ada'
            ];
            header("location: " . $url . "/admin/profile.php?user=" . $user_id . "&role=" . $_POST['role']);
            die();
        }
        $sql_detail = "UPDATE detail_peserta SET nisn = '$nisn', no_telp = '$no_telp', alamat = '$alamat' WHERE id = '$detail_user_id'";
    }
    mysqli_query($conn, $sql_detail);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'Profile berhasil diubah'
    ];
    header("location: " . $url . "/admin/profile.php?user=" . $user_id . "&role=" . $_POST['role']);
}
