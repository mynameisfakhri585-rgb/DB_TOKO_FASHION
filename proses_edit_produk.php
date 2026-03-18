<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['admin'])) {
    header("Location: login.php?pesan=admin");
    exit;
}

// Validasi input
$id = intval($_POST['id']);
$nama = htmlspecialchars($_POST['nama']);
$harga = intval($_POST['harga']);
$harga_lama = $_POST['harga_lama'] ? intval($_POST['harga_lama']) : NULL;
$gambar = htmlspecialchars($_POST['gambar']);
$kategori = htmlspecialchars($_POST['kategori']);

// Validasi data tidak kosong
if($id == 0 || empty($nama) || $harga == 0 || empty($gambar)) {
    echo "<script>
            alert('Mohon lengkapi semua data!');
            window.history.back();
          </script>";
    exit;
}

// Update produk
$query = "UPDATE products SET 
            name = '$nama', 
            price = $harga, 
            old_price = " . ($harga_lama ? "$harga_lama" : "NULL") . ", 
            image = '$gambar', 
            category = '$kategori' 
          WHERE id = $id";

if(mysqli_query($conn, $query)) {
    echo "<script>
            alert('Produk berhasil diperbarui!');
            window.location.href = 'admin.php?pesan=edit';
          </script>";
} else {
    echo "<script>
            alert('Gagal memperbarui produk!');
            window.history.back();
          </script>";
}
?>