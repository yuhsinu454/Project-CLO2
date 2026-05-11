<?php
$host = "localhost";
$user = "adminweb";
$pass = "admin123";
$db   = "db_keamanansinu";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>