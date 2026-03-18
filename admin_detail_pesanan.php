<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['admin'])) {
    header("Location: login.php?pesan=admin");
}

$id = $_GET['id'];
$query_order = mysqli_query($conn, "SELECT * FROM orders WHERE id = $id");
$order = mysqli_fetch_assoc($query_order);
$details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = $id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan #<?php echo $id; ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; }
        
        .sidebar { position: fixed; width: 250px; height: 100%; background: #2c3e50; color: white; padding: 20px; }
        .logo { font-size: 1.5rem; font-weight: 700; margin-bottom: 30px; text-align: center; }
        
        .menu { list-style: none; }
        .menu li { margin-bottom: 10px; }
        .menu a { display: block; padding: 12px; color: #ddd; text-decoration: none; border-radius: 5px; }
        .menu a:hover { background: #e74c3c; color: white; }
        
        .main { margin-left: 250px; padding: 30px; }
        
        .card { background: white; padding: 25px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        
        h1 { color: #2c3e50; margin-bottom: 20px; }
        h2 { font-size: 1rem; color: #333; margin-bottom: 15px; border-bottom: 2px solid #e74c3c; padding-bottom: 5px; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .info p { margin-bottom: 8px; font-size: 0.9rem; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        
        .btn-back { display: inline-block; margin-bottom: 20px; color: #2c3e50; text-decoration: none; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">ZENITH<span>.</span></div>
        <ul class="menu">
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="admin_pesanan.php">Kelola Pesanan</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <a href="admin_pesanan.php" class="btn-back">← Kembali</a>
        <h1>Detail Pesanan #<?php echo $id; ?></h1>
        
        <div class="card">
            <h2>Data Pemesan</h2>
            <div class="info-grid">
                <div class="info">
                    <p><strong>Nama:</strong> <?php echo $order['nama_pemesan']; ?></p>
                    <p><strong>Email:</strong> <?php echo $order['email_pemesan']; ?></p>
                    <p><strong>Telepon:</strong> <?php echo $order['telepon']; ?></p>
                </div>
                <div class="info">
                    <p><strong>Alamat:</strong> <?php echo $order['alamat']; ?></p>
                    <p><strong>Tanggal:</strong> <?php echo date('d M Y, H:i', strtotime($order['tanggal_pesan'])); ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
                </div>
                <!-- Tombol Cetak Invoice -->
<div style="margin-top: 20px;">
    <a href="cetak_invoice.php?id=<?php echo $id; ?>" class="btn-detail" target="_blank" style="background: #2c3e50; padding: 10px 20px; color: white; text-decoration: none; border-radius: 5px;">
        <i class="fas fa-print"></i> Cetak Invoice
    </a>
</div>
            </div>
        </div>
        
        <div class="card">
            <h2>Daftar Produk</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($detail = mysqli_fetch_assoc($details)): ?>
                    <tr>
                        <td><?php echo $detail['nama_produk']; ?></td>
                        <td>Rp <?php echo number_format($detail['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $detail['jumlah']; ?></td>
                        <td>Rp <?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right;">TOTAL</th>
                        <th>Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</body>
</html>