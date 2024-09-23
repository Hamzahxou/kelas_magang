<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
$localhost = "localhost";
$username = "root";
$password = "";
$nama_database = "magang_kelas_db";
$url = "http://localhost:8080/magang_kelas";

$conn = mysqli_connect($localhost, $username, $password, $nama_database);

if (!$conn) {
    die('Koneksi gagal');
}

function hari($day)
{
    switch ($day) {
        case 'Monday':
            return "senin";
            break;
        case 'Tuesday':
            return "selasa";
            break;
        case 'Wednesday':
            return "rabu";
            break;
        case 'Thursday':
            return "kamis";
            break;
        case 'Friday':
            return "jumat";
            break;
        case 'Saturday':
            return "sabtu";
            break;
        case 'Sunday':
            return "minggu";
            break;
        default:
            return $day;
            break;
    }
}


function token($panjang)
{
    global $conn;

    $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $length = strlen($string) - 1;
    $randomString = '';
    for ($i = 0; $i < $panjang; $i++) {
        $randomString .= $string[rand(0, $length)];
    }
    $sql_cek_token = "SELECT * FROM kelas WHERE token = '$randomString'";
    $cek_token = $conn->query($sql_cek_token);
    if ($cek_token->num_rows > 0) {
        return token($panjang);
    } else {
        return $randomString;
    }
}
