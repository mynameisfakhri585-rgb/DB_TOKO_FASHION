<?php
session_start();
include 'koneksi.php';

// Cek apakah admin sudah login
if(!isset($_SESSION['admin'])) {
    header("Location: login.php?pesan=admin");
    exit;
}

// Validasi input
if(!isset($_POST['id']) || !isset($_POST['status'])) {
    header("Location: admin_pesanan.php");
    exit;
}

$id = intval($_POST['id']); // Amankan input angka
$status = htmlspecialchars($_POST['status']);

// Validasi status yang diperbolehkan
$allowed_status = ['pending', 'dikonfirmasi', 'dikirim', 'selesai'];
if(!in_array($status, $allowed_status)) {
    header("Location: admin_pesanan.php?pesan=invalid");
    exit;
}

// Update status pesanan
$query = mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE id = $id");

if($query) {
    header("Location: admin_pesanan.php?pesan=update");
    exit;
} else {
    header("Location: admin_pesanan.php?pesan=gagal");
    exit;
}
?>