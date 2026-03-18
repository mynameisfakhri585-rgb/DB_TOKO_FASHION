<?php
include 'koneksi.php';

$id = $_GET['id'];

// Ambil data pesanan
$query_order = mysqli_query($conn, "SELECT * FROM orders WHERE id = $id");
$order = mysqli_fetch_assoc($query_order);

// Ambil detail pesanan
$query_details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = $id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo $order['id']; ?> - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        .invoice-box {
            max-width: 800px;
            margin: 30px auto;
            padding: 40px;
            background: white;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .header { display: flex; justify-content: space-between; margin-bottom: 40px; border-bottom: 2px solid #2c3e50; padding-bottom: 20px; }
        .logo { font-size: 2rem; font-weight: 700; color: #2c3e50; }
        .logo span { color: #e74c3c; }
        
        .invoice-title { text-align: right; }
        .invoice-title h1 { font-size: 2.5rem; color: #2c3e50; }
        .invoice-title p { color: #666; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
        .info-box h3 { font-size: 0.9rem; color: #666; margin-bottom: 10px; text-transform: uppercase; }
        .info-box p { margin-bottom: 5px; font-size: 0.9rem; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8f9fa; color: #333; font-size: 0.85rem; text-transform: uppercase; }
        
        .totals { text-align: right; }
        .total-row { display: flex; justify-content: flex-end; padding: 10px 0; border-top: 2px solid #2c3e50; }
        .total-row span:first-child { width: 150px; font-weight: 600; }
        .total-row span:last-child { font-weight: 700; font-size: 1.2rem; color: #e74c3c; }
        
        .footer { text-align: center; margin-top: 40px; color: #666; font-size: 0.8rem; }
        
        .btn-print { 
            position: fixed; 
            top: 20px; 
            right: 20px; 
            padding: 12px 25px; 
            background: #2c3e50; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer;
            font-weight: 600;
        }
        .btn-print:hover { background: #e74c3c; }
        
        @media print {
            .btn-print { display: none; }
            .invoice-box { box-shadow: none; margin: 0; }
        }
    </style>
</head>
<body>

    <button class="btn-print" onclick="window.print()">
        <i class="fas fa-print"></i> Cetak Invoice
    </button>

    <div class="invoice-box">
        <!-- Header -->
        <div class="header">
            <div class="logo">ZENITH<span>.</span></div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <p>No. Pesanan: #<?php echo $order['id']; ?></p>
                <p>Tanggal: <?php echo date('d M Y', strtotime($order['tanggal_pesan'])); ?></p>
            </div>
        </div>
        
        <!-- Info Pemesan & Pengiriman -->
        <div class="info-grid">
            <div class="info-box">
                <h3>Dikirim Kepada</h3>
                <p><strong><?php echo $order['nama_pemesan']; ?></strong></p>
                <p><?php echo $order['alamat']; ?></p>
                <p>Telp: <?php echo $order['telepon']; ?></p>
            </div>
            <div class="info-box">
                <h3>Status Pesanan</h3>
                <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
                <p><strong>Pembayaran:</strong> Transfer Bank</p>
            </div>
        </div>
        
        <!-- Daftar Produk -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($detail = mysqli_fetch_assoc($query_details)):
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $detail['nama_produk']; ?></td>
                    <td>Rp <?php echo number_format($detail['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $detail['jumlah']; ?></td>
                    <td>Rp <?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <!-- Total -->
        <div class="totals">
            <div class="total-row">
                <span>TOTAL PEMBAYARAN</span>
                <span>Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></span>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah berbelanja di <strong>Zenith Fashion</strong></p>
            <p>Jika ada pertanyaan, hubungi kami di admin@zenith.com</p>
        </div>
    </div>

</body>
</html>