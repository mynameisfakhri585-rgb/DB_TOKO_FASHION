<?php
include 'koneksi.php';
$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM orders WHERE id = $id");
$order = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        
        .card { background: white; padding: 40px; border-radius: 10px; text-align: center; max-width: 500px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        
        .icon { font-size: 4rem; color: #27ae60; margin-bottom: 20px; }
        h1 { color: #2c3e50; margin-bottom: 10px; }
        p { color: #666; margin-bottom: 5px; }
        
        .order-info { background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: left; }
        .order-info p { margin-bottom: 8px; }
        .order-id { font-weight: 700; color: #e74c3c; font-size: 1.2rem; }
        
        .btn-group { display: flex; gap: 10px; justify-content: center; margin-top: 20px; }
        .btn { padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: 600; transition: 0.3s; }
        .btn-primary { background: #2c3e50; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>

    <div class="card">
        <div class="icon"><i class="fas fa-check-circle"></i></div>
        <h1>Pesanan Berhasil!</h1>
        <p>Terima kasih telah berbelanja di <strong>Zenith Fashion</strong></p>
        
        <div class="order-info">
            <p><strong>Nomor Pesanan:</strong> <span class="order-id">#<?php echo $order['id']; ?></span></p>
            <p><strong>Nama:</strong> <?php echo $order['nama_pemesan']; ?></p>
            <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
            <p><strong>Tanggal:</strong> <?php echo date('d M Y, H:i', strtotime($order['tanggal_pesan'])); ?></p>
        </div>
        
        <p style="font-size: 0.9rem;">Kami akan menghubungi Anda untuk konfirmasi pesanan.</p>
        
        <div class="btn-group">
            <a href="cetak_invoice.php?id=<?php echo $order['id']; ?>" class="btn btn-primary" target="_blank">
                <i class="fas fa-print"></i> Cetak Invoice
            </a>
            <div style="margin-top: 15px;">
    <a href="lacak_pesanan.php?order_id=<?php echo $order['id']; ?>" style="color: #3498db; text-decoration: none; font-size: 0.9rem;">
        <i class="fas fa-search"></i> Lihat Status Pesanan
    </a>
</div>
            <a href="index.php" class="btn btn-success">Kembali ke Toko</a>
        </div>
    </div>

</body>
</html>