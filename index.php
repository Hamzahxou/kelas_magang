<?php
include_once('config/database.php');
if (isset($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];
    header("location: " . $url . "/" . $role);
} else {
    header("location: " . $url . "/login");
}
