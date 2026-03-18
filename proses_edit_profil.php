<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id_user'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$konfirmasi = $_POST['konfirmasi_password'];

// Validasi konfirmasi password
if($password != "" && $password != $konfirmasi) {
    echo "<script>
            alert('Konfirmasi password tidak cocok!');
            window.history.back();
          </script>";
    exit;
}

// Cek email sudah terpakai orang lain
$cek_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND id != $user_id");
if(mysqli_num_rows($cek_email) > 0) {
    echo "<script>
            alert('Email sudah digunakan!');
            window.history.back();
          </script>";
    exit;
}

// Update data
if($password != "") {
    $query = "UPDATE users SET name = '$nama', email = '$email', password = '$password' WHERE id = $user_id";
} else {
    $query = "UPDATE users SET name = '$nama', email = '$email' WHERE id = $user_id";
}

if(mysqli_query($conn, $query)) {
    $_SESSION['nama'] = $nama;
    $_SESSION['email'] = $email;
    
    echo "<script>
            alert('Profil berhasil diperbarui!');
            window.location.href = 'profil.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal memperbarui profil!');
            window.history.back();
          </script>";
}
?>