<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: lupa_password.php");
    exit;
}

$email = $_SESSION['reset_email'];
$otp_input = mysqli_real_escape_string($conn, $_POST['otp']);

// 1. Cari user berdasarkan email
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($query);

if ($user) {
    $db_otp = $user['otp_code'];
    $db_expiry = $user['otp_expiry'];
    $current_time = date('Y-m-d H:i:s');

    // 2. Cek apakah OTP cocok
    if ($db_otp === $otp_input) {
        
        // 3. Cek apakah waktu masih berlaku
        if ($db_expiry > $current_time) {
            // Berhasil! Buat token reset
            $token = bin2hex(random_bytes(32));
            mysqli_query($conn, "UPDATE users SET reset_token='$token', otp_code=NULL, otp_attempts=0 WHERE email='$email'");
            
            header("Location: reset_password.php?token=$token");
            exit;
        } else {
            echo "<script>alert('Waktu habis! Kode OTP sudah kadaluwarsa (lebih dari 2 menit).'); window.location.href='verifikasi_otp.php';</script>";
        }
    } else {
        echo "<script>alert('Kode OTP yang Anda masukkan salah!'); window.location.href='verifikasi_otp.php';</script>";
    }
} else {
    header("Location: lupa_password.php");
}
?>