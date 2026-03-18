<?php
include 'koneksi.php';

// Ambil data dari form
$nama  = mysqli_real_escape_string($conn, $_POST['nama']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass  = mysqli_real_escape_string($conn, $_POST['password']);
// Tangkap input warna keamanan dan ubah ke huruf kecil untuk konsistensi
$warna = strtolower(mysqli_real_escape_string($conn, $_POST['warna_keamanan']));

// 1. Cek apakah email sudah terdaftar
$sql_cek = "SELECT * FROM users WHERE email='$email'";
$query_cek = mysqli_query($conn, $sql_cek);

// Pastikan variabel query tidak null dan cek jumlah baris
if (mysqli_num_rows($query_cek) > 0) {
    // Jika email sudah ada, kembali ke halaman register dengan pesan gagal
    header("location:register.php?pesan=gagal");
} else {
    // 2. Jika email belum ada, masukkan data ke database (termasuk warna_keamanan)
    $sql_insert = "INSERT INTO users (name, email, password, warna_keamanan) 
                   VALUES ('$nama', '$email', '$pass', '$warna')";
    
    if (mysqli_query($conn, $sql_insert)) {
        echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>