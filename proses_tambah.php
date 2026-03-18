<?php
include 'koneksi.php';

$nama = $_POST['nama'];
$harga = $_POST['harga'];
$harga_lama = $_POST['harga_lama'] ? $_POST['harga_lama'] : NULL;
$gambar = $_POST['gambar'];
$kategori = $_POST['kategori'];

$query = "INSERT INTO products (name, price, old_price, image, category) 
          VALUES ('$nama', '$harga', '$harga_lama', '$gambar', '$kategori')";

if(mysqli_query($conn, $query)) {
    echo "<script>
            alert('Produk berhasil ditambahkan!');
            window.location.href = 'admin.php';
          </script>";
} else {
    echo "Gagal menambahkan produk!";
}
?>