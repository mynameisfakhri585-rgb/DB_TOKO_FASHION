<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; }
        
        .container { max-width: 700px; margin: 120px auto 2rem; padding: 20px; }
        
        .tracking-card { background: white; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); overflow: hidden; }
        
        .tracking-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            padding: 40px;
            text-align: center;
            color: white;
        }
        .tracking-header i { font-size: 3rem; margin-bottom: 15px; }
        .tracking-header h1 { font-size: 1.8rem; margin-bottom: 10px; }
        .tracking-header p { opacity: 0.8; }
        
        .tracking-body { padding: 30px; }
        
        .search-box { display: flex; gap: 10px; margin-bottom: 30px; }
        .search-box input {
            flex: 1;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        .search-box input:focus { outline: none; border-color: #2c3e50; }
        .search-box button {
            padding: 15px 30px;
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        .search-box button:hover { background: #e74c3c; }
        
        /* Timeline Status */
        .order-result { display: none; }
        
        .order-info {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .order-info h3 { color: #2c3e50; margin-bottom: 15px; }
        .order-info p { margin-bottom: 8px; font-size: 0.9rem; }
        .order-id { font-weight: 700; color: #e74c3c; font-size: 1.2rem; }
        
        .status-timeline { margin-top: 30px; }
        .status-timeline h3 { margin-bottom: 20px; color: #333; }
        
        .timeline { position: relative; padding-left: 30px; }
        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #ddd;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 25px;
        }
        
        .timeline-item:last-child { padding-bottom: 0; }
        
        .timeline-dot {
            position: absolute;
            left: -26px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #ddd;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #ddd;
        }
        
        .timeline-item.active .timeline-dot {
            background: #27ae60;
            box-shadow: 0 0 0 2px #27ae60;
        }
        
        .timeline-content h4 { color: #333; font-size: 1rem; margin-bottom: 5px; }
        .timeline-content p { color: #666; font-size: 0.85rem; }
        
        .timeline-item.active .timeline-content h4 { color: #27ae60; }
        
        .btn-back { display: inline-block; margin-bottom: 15px; color: #666; text-decoration: none; }
        .btn-back:hover { color: #2c3e50; }
        
        .not-found { text-align: center; padding: 30px; color: #e74c3c; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
    
    <div class="tracking-card">
        <div class="tracking-header">
            <i class="fas fa-shipping-fast"></i>
            <h1>Lacak Pesanan</h1>
            <p>Masukkan nomor pesanan untuk melihat status pengiriman</p>
        </div>
        
        <div class="tracking-body">
            <!-- Form Pencarian -->
            <form method="GET" class="search-box">
                <input type="number" name="order_id" placeholder="Masukkan Nomor Pesanan (contoh: 1)" required>
                <button type="submit"><i class="fas fa-search"></i> Lacak</button>
            </form>
            
            <?php if(isset($_GET['order_id'])): ?>
                <?php
                $order_id = $_GET['order_id'];
                
                // Jika login, hanya bisa lacak pesanan sendiri
                if(isset($_SESSION['user'])) {
                    $user_id = $_SESSION['id_user'];
                    $query = mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id");
                } else {
                    // Jika guest, wajib masukkan email
                    if(isset($_GET['email'])) {
                        $email = $_GET['email'];
                        $query = mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id AND email_pemesan = '$email'");
                    } else {
                        $query = mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id");
                    }
                }
                
                $order = mysqli_fetch_assoc($query);
                ?>
                
                <?php if($order): ?>
                <div class="order-result" style="display: block;">
                    <div class="order-info">
                        <h3>Informasi Pesanan</h3>
                        <p><strong>Nomor Pesanan:</strong> <span class="order-id">#<?php echo $order['id']; ?></span></p>
                        <p><strong>Nama:</strong> <?php echo $order['nama_pemesan']; ?></p>
                        <p><strong>Tanggal Pesan:</strong> <?php echo date('d M Y, H:i', strtotime($order['tanggal_pesan'])); ?></p>
                        <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></p>
                        <p><strong>Alamat:</strong> <?php echo $order['alamat']; ?></p>
                    </div>
                    
                    <div class="status-timeline">
                        <h3>Status Pengiriman</h3>
                        <div class="timeline">
                            
                            <!-- Status 1: Pending -->
                            <div class="timeline-item <?php echo in_array($order['status'], ['pending', 'dikonfirmasi', 'dikirim', 'selesai']) ? 'active' : ''; ?>">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <h4>Pesanan Diterima</h4>
                                    <p>Pesanan Anda telah kami terima dan sedang diproses.</p>
                                </div>
                            </div>
                            
                            <!-- Status 2: Dikonfirmasi -->
                            <div class="timeline-item <?php echo in_array($order['status'], ['dikonfirmasi', 'dikirim', 'selesai']) ? 'active' : ''; ?>">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <h4>Pesanan Dikonfirmasi</h4>
                                    <p>Pesanan telah dikonfirmasi dan sedang disiapkan.</p>
                                </div>
                            </div>
                            
                            <!-- Status 3: Dikirim -->
                            <div class="timeline-item <?php echo in_array($order['status'], ['dikirim', 'selesai']) ? 'active' : ''; ?>">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <h4>Sedang Dikirim</h4>
                                    <p>Pesanan sedang dalam perjalanan ke alamat tujuan.</p>
                                </div>
                            </div>
                            
                            <!-- Status 4: Selesai -->
                            <div class="timeline-item <?php echo $order['status'] == 'selesai' ? 'active' : ''; ?>">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <h4>Pesanan Selesai</h4>
                                    <p>Pesanan telah diterima oleh pelanggan.</p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div style="margin-top: 25px; text-align: center;">
                        <a href="cetak_invoice.php?id=<?php echo $order['id']; ?>" target="_blank" style="color: #3498db; text-decoration: none;">
                            <i class="fas fa-print"></i> Cetak Invoice
                        </a>
                    </div>
                </div>
                <?php else: ?>
                <div class="not-found">
                    <i class="fas fa-times-circle" style="font-size: 3rem; margin-bottom: 10px;"></i>
                    <p>Pesanan tidak ditemukan!</p>
                    <small>Mohon periksa kembali nomor pesanan Anda.</small>
                </div>
                <?php endif; ?>
                
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>