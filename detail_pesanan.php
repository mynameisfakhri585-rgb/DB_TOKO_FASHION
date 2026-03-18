<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
    header("Location: login.php");
}

$id = $_GET['id'];
$user_id = $_SESSION['id_user'];

// Cek pesanan milik user atau bukan
$query = mysqli_query($conn, "SELECT * FROM orders WHERE id = $id AND user_id = $user_id");
$order = mysqli_fetch_assoc($query);

if(!$order) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location.href='riwayat_pesanan.php';</script>";
    exit;
}

$details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = $id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; }
        
        .container { max-width: 800px; margin: 100px auto 2rem; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        
        h1 { color: #2c3e50; margin-bottom: 20px; }
        h2 { font-size: 1.1rem; color: #333; margin-bottom: 15px; border-bottom: 2px solid #e74c3c; padding-bottom: 10px; }
        
        .btn-back { display: inline-block; margin-bottom: 15px; color: #2c3e50; text-decoration: none; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .info-box { background: #f9f9f9; padding: 15px; border-radius: 5px; }
        .info-box p { margin-bottom: 8px; font-size: 0.9rem; }
        .info-box strong { color: #2c3e50; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #2c3e50; color: white; font-size: 0.9rem; }
        
        .total-box { text-align: right; margin-top: 20px; font-size: 1.2rem; font-weight: 700; color: #e74c3c; }
    </style>
</head>
<body>

<div class="container">
    <a href="riwayat_pesanan.php" class="btn-back">← Kembali ke Riwayat</a>
    <h1>Detail Pesanan #<?php echo $order['id']; ?></h1>
    
    <div class="info-grid">
        <div class="info-box">
            <h2>Data Pemesan</h2>
            <p><strong>Nama:</strong> <?php echo $order['nama_pemesan']; ?></p>
            <p><strong>Email:</strong> <?php echo $order['email_pemesan']; ?></p>
            <p><strong>Telepon:</strong> <?php echo $order['telepon']; ?></p>
            <p><strong>Alamat:</strong> <?php echo $order['alamat']; ?></p>
        </div>
        <div class="info-box">
            <h2>Status Pesanan</h2>
            <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
            <p><strong>Tanggal Pesan:</strong> <?php echo date('d M Y, H:i', strtotime($order['tanggal_pesan'])); ?></p>
        </div>
    </div>
    
    <h2>Daftar Produk</h2>
    <table>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
        <?php while($detail = mysqli_fetch_assoc($details)): ?>
        <tr>
            <td><?php echo $detail['nama_produk']; ?></td>
            <td>Rp <?php echo number_format($detail['harga'], 0, ',', '.'); ?></td>
            <td><?php echo $detail['jumlah']; ?></td>
            <td>Rp <?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <div class="total-box">
        Total Pembayaran: Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?>
    </div>
    <!-- Tambahkan tombol cetak invoice -->
<div style="margin-top: 20px;">
    <a href="cetak_invoice.php?id=<?php echo $order['id']; ?>" class="btn-detail" target="_blank">
        <i class="fas fa-print"></i> Cetak Invoice
    </a>
</div>
</div>

</body>
</html>