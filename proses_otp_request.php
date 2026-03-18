<?php
session_start();
include 'koneksi.php';

$email = mysqli_real_escape_string($conn, $_POST['email']);
$warna = strtolower(mysqli_real_escape_string($conn, $_POST['warna']));

// Validasi Email dan Warna Keamanan
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND warna_keamanan='$warna'");
$user = mysqli_fetch_assoc($query);

if ($user) {
    // Batasi percobaan maksimal 5 kali
    if ($user['otp_attempts'] >= 5) {
        echo "<script>alert('Terlalu banyak mencoba. Akun diblokir sementara.'); window.location.href='lupa_password.php';</script>";
        exit;
    }

    // Buat OTP 6 digit dan durasi 2 menit
    $otp = rand(100000, 999999);
    $expiry = date('Y-m-d H:i:s', strtotime('+2 minutes'));

    // Simpan ke database
    $update = mysqli_query($conn, "UPDATE users SET 
        otp_code='$otp', 
        otp_expiry='$expiry', 
        otp_attempts = otp_attempts + 1 
        WHERE email='$email'");

    if ($update) {
        $_SESSION['reset_email'] = $email;
        // Simulasi pengiriman kode melalui alert (karena di localhost)
        echo "<script>alert('NOTIFIKASI: Kode OTP Anda adalah $otp. Berlaku 2 menit.'); window.location.href='verifikasi_otp.php';</script>";
    }
} else {
    echo "<script>alert('Data tidak cocok! Email atau Warna salah.'); window.location.href='lupa_password.php';</script>";
}
?>