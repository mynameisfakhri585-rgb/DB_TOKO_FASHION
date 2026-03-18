<?php
session_start();

include 'koneksi.php';

$id_produk = $_GET['id'];

// Ambil data produk dari database
$query = "SELECT * FROM products WHERE id = $id_produk";
$result = mysqli_query($conn, $query);
$produk = mysqli_fetch_assoc($result);

if ($produk) {
    // Cek apakah keranjang sudah ada
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Cek jika produk sudah ada di keranjang, tambah quantity
    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk]['qty'] += 1;
    } else {
        $_SESSION['keranjang'][$id_produk] = [
            'nama' => $produk['name'],
            'harga' => $produk['price'],
            'gambar' => $produk['image'],
            'qty' => 1
        ];
    }

    echo "<script>
            alert('Produk telah ditambahkan ke keranjang!');
            window.location.href = 'index.php';
          </script>";
} else {
    echo "Produk tidak ditemukan!";
}
?>