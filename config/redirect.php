<?php
include_once('../config/database.php');
$parse_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parse_url = explode("/", $parse_url);
$get_parse_url = $parse_url[2];

if (isset($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];
    if ($role != $get_parse_url) {
        header("location: " . $url . "/" . $role);
    } else {
        $user = $_SESSION['user'];
        if ($user['role'] == "siswa") {
            $sql_peserta =  "SELECT peserta.id,peserta.user_id FROM peserta 
            INNER JOIN users ON peserta.user_id = users.id
            WHERE user_id = '$user[id]'";
            $query_peserta = $conn->query($sql_peserta);
            $peserta_magang = $query_peserta->fetch_assoc();
        }
    }
} else {
    header("location: " . $url . "/login");
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: " . $url . "/index.php");
}


// $user_id = $user['id'];
// $sql = "SELECT * FROM jadwal
// LEFT JOIN kelas ON jadwal.kelas_id = kelas.id
// WHERE guru_id = '$user_id'
// ";
// $result = $conn->query($sql);
// $sql_peserta = "SELECT user_id,kelas_id,username FROM peserta 
// INNER JOIN users ON peserta.user_id = users.id
// ";
// $query_peserta = $conn->query($sql_peserta);
// $result_peserta = [];
// foreach ($query_peserta as $peserta) {
//     $result_peserta[] = $peserta;
// }

// $data = [];
// foreach ($result as $i => $baris) {
//     $jadwal_id = $baris['kelas_id'];
//     if (!isset($data[$jadwal_id])) {
//         $data[$jadwal_id] = [
//             'id' => $i,
//             'waktu_mulai' => $baris['waktu_mulai'],
//             'waktu_selesai' => $baris['waktu_selesai'],
//             'pesan' => $baris['pesan'],
//             'kelas_id' => $baris['kelas_id'],
//             'nama_kelas' => $baris['nama_kelas'],
//             'deskripsi' => $baris['deskripsi'],
//             'tanggal_mulai' => $baris['tanggal_mulai'],
//             'tanggal_berakhir' => $baris['tanggal_berakhir'],
//             'guru_id' => $baris['guru_id'],
//             'peserta' => []
//         ];
//     }

//     // Tambahkan peserta ke dalam array peserta jadwal tersebut
//     foreach ($result_peserta as $peserta) {
//         if ($baris['kelas_id'] == $peserta['kelas_id']) {
//             $data[$jadwal_id]['peserta'][] = [
//                 'username' => $peserta['username'],
//                 'user_id' => $peserta['user_id'],
//             ];
//         }
//     }
// }
// print_r($data);
// die();
