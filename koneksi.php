<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_toko_fashion";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>