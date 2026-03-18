<?php
session_start();
include 'koneksi.php';

if(isset($_SESSION['reset_email'])){
    $email = $_SESSION['reset_email'];
    
    // Bersihkan OTP dan masa berlaku di database agar kode tidak bisa dipakai lagi
    $query = "UPDATE users SET otp_code = NULL, otp_expiry = NULL WHERE email = '$email'";
    mysqli_query($conn, $query);
    
    // Hapus session
    unset($_SESSION['reset_email']);
}

// Redirect kembali ke login dengan notifikasi bersih
echo "<script>alert('Notifikasi dihapus. Sesi dibatalkan.'); window.location.href='login.php';</script>";
?>