<?php
include 'koneksi.php';

$token = $_POST['token'];
$password = $_POST['password_baru'];
$konfirmasi = $_POST['konfirmasi_password'];

// Validasi
if($password != $konfirmasi) {
    echo "<script>alert('Password tidak cocok!'); window.history.back();</script>";
    exit;
}

if(strlen($password) < 6) {
    echo "<script>alert('Password minimal 6 karakter!'); window.history.back();</script>";
    exit;
}

// Update password
$query = mysqli_query($conn, "SELECT * FROM users WHERE reset_token = '$token'");

if(mysqli_num_rows($query) > 0) {
    $user = mysqli_fetch_assoc($query);
    
    // Update password dan hapus token
    mysqli_query($conn, "UPDATE users SET password = '$password', reset_token = NULL, reset_expire = NULL WHERE id = " . $user['id']);
    
    echo "<script>
            alert('Password berhasil diubah! Silakan login.');
            window.location.href = 'login.php';
          </script>";
} else {
    echo "<script>alert('Token tidak valid!'); window.location.href = 'login.php';</script>";
}
?>