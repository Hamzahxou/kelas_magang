<?php
include_once('../database.php');
if (isset($_POST['tambah_user'])) {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $noTelp = $_POST['noTelp'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $cek_user = "SELECT * FROM users WHERE email = '$email'";
    $cek_user = mysqli_query($conn, $cek_user);
    if (mysqli_num_rows($cek_user) > 0) {
        $_SESSION['flash_alert'] = [
            'type' => 'danger',
            'pesan' => 'Email sudah ada'
        ];
    } else {

        if ($role == 'guru') {
            $nip = $_POST['nip'];
            $sql_cek_detail = "SELECT * FROM detail_guru WHERE nip = '$nip' OR no_telp = '$noTelp'";
            $cek_detail = mysqli_query($conn, $sql_cek_detail);
            $cek_detail = $cek_detail->fetch_assoc();
            if ($cek_detail['nip'] == $nip) {
                $_SESSION['flash_alert'] = [
                    'type' => 'danger',
                    'pesan' => 'Nip sudah ada'
                ];
                header("location: " . $url . "/admin/users.php");
                die();
            } elseif ($cek_detail['no_telp'] == $noTelp) {
                $_SESSION['flash_alert'] = [
                    'type' => 'danger',
                    'pesan' => 'No Telp sudah ada'
                ];
                header("location: " . $url . "/admin/users.php");
                die();
            }
        } else if ($role == 'siswa') {
            $nisn = $_POST['nisn'];

            $sql_cek_detail = "SELECT * FROM detail_peserta WHERE nisn = '$nisn' OR no_telp = '$noTelp'";
            $cek_detail = mysqli_query($conn, $sql_cek_detail);
            $cek_detail = $cek_detail->fetch_assoc();
            if ($cek_detail['nisn'] == $nisn) {
                $_SESSION['flash_alert'] = [
                    'type' => 'danger',
                    'pesan' => 'Nisn sudah ada'
                ];
                header("location: " . $url . "/admin/users.php");
                die();
            } elseif ($cek_detail['no_telp'] == $noTelp) {
                $_SESSION['flash_alert'] = [
                    'type' => 'danger',
                    'pesan' => 'No Telp sudah ada'
                ];
                header("location: " . $url . "/admin/users.php");
                die();
            }
        }


        $sql = "INSERT INTO users (username, role, email, password) VALUES ('$username', '$role', '$email', '$password')";
        mysqli_query($conn, $sql);
        $user_id = mysqli_insert_id($conn);

        if ($role == 'guru') {
            $nip = $_POST['nip'];

            $sql_guru = "INSERT INTO detail_guru (user_id, no_telp, nip) VALUES ('$user_id', '$noTelp', '$nip')";
            mysqli_query($conn, $sql_guru);
        } else if ($role == 'siswa') {
            $nisn = $_POST['nisn'];

            $sql_siswa = "INSERT INTO detail_peserta (user_id, no_telp, nisn) VALUES ('$user_id', '$noTelp', '$nisn')";
            mysqli_query($conn, $sql_siswa);
        }

        $_SESSION['flash_alert'] = [
            'type' => 'success',
            'pesan' => 'User berhasil ditambahkan'
        ];
    }
    header("location: " . $url . "/admin/users.php");
}
if (isset($_POST['hapus_user'])) {
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM users WHERE id = '$user_id'";
    mysqli_query($conn, $sql);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'User berhasil dihapus'
    ];
    header("location: " . $url . "/admin/users.php");
}
if (isset($_POST['edit_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    if (empty($_POST['password'])) {
        $password = $_POST['password_db'];
    }
    $sql = "UPDATE users SET username = '$username', email = '$email', password = '$password' WHERE id = '$user_id'";
    mysqli_query($conn, $sql);
    $_SESSION['flash_alert'] = [
        'type' => 'success',
        'pesan' => 'User berhasil diubah'
    ];
    header("location: " . $url . "/admin/users.php");
}
