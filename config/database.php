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
