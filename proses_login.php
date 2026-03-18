<?php
session_start();
include 'koneksi.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Cek user di database
$query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

if(mysqli_num_rows($query) > 0) {
    $user = mysqli_fetch_assoc($query);
    
    // Verifikasi password (cek plain text atau bisa pakai password_verify jika di-hash)
    if($password == $user['password']) {
        // Login berhasil, buat session
        $_SESSION['id_user'] = $user['id'];
        $_SESSION['nama'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        
        if($user['role'] == 'admin') {
            $_SESSION['admin'] = true;
            header("Location: admin.php");
        } else {
            $_SESSION['user'] = true;
            header("Location: index.php");
        }
    } else {
        header("Location: login.php?pesan=gagal");
    }
} else {
    header("Location: login.php?pesan=gagal");
}
?>