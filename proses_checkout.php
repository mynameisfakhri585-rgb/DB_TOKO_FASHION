<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0) {
    header("Location: index.php");
    exit;
}

$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];
$total_harga = $_POST['total_harga'];
$payment_method = $_POST['payment_method']; // Ambil metode pembayaran

$user_id = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : NULL;

// Simpan ke tabel orders
$query_order = "INSERT INTO orders (user_id, nama_pemesan, email_pemesan, telepon, alamat, total_harga, payment_method) 
                VALUES ('$user_id', '$nama', '$email', '$telepon', '$alamat', '$total_harga', '$payment_method')";

if(mysqli_query($conn, $query_order)) {
    
    $order_id = mysqli_insert_id($conn);
    
    // Simpan detail pesanan
    foreach($_SESSION['keranjang'] as $id => $item) {
        $produk_id = $id;
        $nama_produk = $item['nama'];
        $harga = $item['harga'];
        $jumlah = $item['qty'];
        $subtotal = $harga * $jumlah;
        
        mysqli_query($conn, "INSERT INTO order_details (order_id, produk_id, nama_produk, harga, jumlah, subtotal) 
                            VALUES ('$order_id', '$produk_id', '$nama_produk', '$harga', '$jumlah', '$subtotal')");
    }
    
    // Hapus keranjang
    unset($_SESSION['keranjang']);
    
    // Redirect ke halaman instruksi pembayaran
    echo "<script>
            alert('Pesanan berhasil! Nomor Pesanan: #$order_id');
            window.location.href = 'instruksi_pembayaran.php?id=$order_id';
          </script>";
} else {
    echo "Gagal memproses pesanan!";
}
?>