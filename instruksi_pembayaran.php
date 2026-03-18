<?php
include 'koneksi.php';
$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM orders WHERE id = $id");
$order = mysqli_fetch_assoc($query);

// Nama metode pembayaran
$method_names = [
    'transfer_bank' => 'Transfer Bank',
    'dana' => 'DANA',
    'ovo' => 'OVO',
    'cod' => 'Bayar di Tempat (COD)'
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        
        .card { background: white; padding: 40px; border-radius: 10px; max-width: 600px; width: 100%; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        
        .icon { font-size: 4rem; color: #27ae60; margin-bottom: 20px; text-align: center; }
        h1 { color: #2c3e50; margin-bottom: 10px; text-align: center; }
        p { color: #666; text-align: center; margin-bottom: 20px; }
        
        .order-box { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px; }
        .order-box p { text-align: left; margin-bottom: 10px; }
        .order-id { font-size: 1.5rem; font-weight: 700; color: #e74c3c; }
        
        .payment-info { border: 2px dashed #3498db; padding: 20px; border-radius: 8px; margin-bottom: 25px; }
        .payment-info h3 { color: #333; margin-bottom: 15px; text-align: center; }
        
        .bank-list { display: grid; gap: 15px; }
        .bank-item { display: flex; justify-content: space-between; align-items: center; padding: 15px; background: white; border: 1px solid #ddd; border-radius: 8px; }
        .bank-name { font-weight: 600; color: #2c3e50; }
        .bank-number { font-family: monospace; font-size: 1.1rem; color: #2c3e50; font-weight: 700; }
        .copy-btn { background: #3498db; color: white; border: none; padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; cursor: pointer; margin-left: 10px; }
        
        .ewallet-info { text-align: center; }
        .ewallet-info p { margin-bottom: 15px; }
        .ewallet-number { font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin: 10px 0; }
        
        .cod-info { text-align: center; background: #fff3cd; padding: 20px; border-radius: 8px; border: 1px solid #ffc107; }
        .cod-info i { font-size: 2rem; color: #ffc107; margin-bottom: 10px; }
        
        .btn { display: block; padding: 15px 30px; background: #27ae60; color: white; text-decoration: none; border-radius: 5px; font-weight: 600; text-align: center; width: 100%; transition: 0.3s; margin-top: 20px; }
        .btn:hover { background: #219150; }
        .btn-secondary { background: #3498db; margin-top: 10px; }
        .btn-secondary:hover { background: #2980b9; }
        
        .note { background: #e8f4fd; padding: 15px; border-radius: 8px; margin-top: 20px; font-size: 0.85rem; color: #0d5e8f; text-align: left; }
        .note i { margin-right: 8px; }
    </style>
</head>
<body>

    <div class="card">
        <div class="icon"><i class="fas fa-check-circle"></i></div>
        <h1>Pesanan Diterima!</h1>
        <p>Silakan lakukan pembayaran sesuai metode yang dipilih.</p>
        
        <!-- Info Pesanan -->
        <div class="order-box">
            <p><strong>Nomor Pesanan:</strong> <span class="order-id">#<?php echo $order['id']; ?></span></p>
            <p><strong>Total Pembayaran:</strong> <span style="color: #e74c3c; font-weight: 700; font-size: 1.2rem;">Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></span></p>
            <p><strong>Metode Pembayaran:</strong> <?php echo $method_names[$order['payment_method']]; ?></p>
        </div>
        
        <!-- Transfer Bank -->
        <?php if($order['payment_method'] == 'transfer_bank'): ?>
        <div class="payment-info">
            <h3><i class="fas fa-university"></i> Transfer ke Rekening Berikut:</h3>
            <div class="bank-list">
                <div class="bank-item">
                    <span class="bank-name"><i class="fas fa-building"></i> Bank BCA</span>
                    <span class="bank-number">1234567890 <button class="copy-btn" onclick="copyToClipboard('1234567890')">Copy</button></span>
                </div>
                <div class="bank-item">
                    <span class="bank-name"><i class="fas fa-building"></i> Bank BRI</span>
                    <span class="bank-number">9876543210 <button class="copy-btn" onclick="copyToClipboard('9876543210')">Copy</button></span>
                </div>
                <div class="bank-item">
                    <span class="bank-name"><i class="fas fa-building"></i> Bank Mandiri</span>
                    <span class="bank-number">555566667777 <button class="copy-btn" onclick="copyToClipboard('555566667777')">Copy</button></span>
                </div>
            </div>
            <p style="margin-top: 15px; font-size: 0.9rem; color: #666; text-align: center;">
                <strong>atas nama:</strong> TOKO ZENITH FASHION
            </p>
        </div>
        <?php endif; ?>
        
        <!-- DANA -->
        <?php if($order['payment_method'] == 'dana'): ?>
        <div class="payment-info">
            <h3><i class="fas fa-wallet"></i> Pembayaran via DANA</h3>
            <div class="ewallet-info">
                <p>Silakan transfer ke nomor DANA berikut:</p>
                <div class="ewallet-number">0812 3456 7890</div>
                <button class="btn" style="background: #3498db; margin-top: 10px;" onclick="copyToClipboard('081234567890')">Copy Nomor DANA</button>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- OVO -->
        <?php if($order['payment_method'] == 'ovo'): ?>
        <div class="payment-info">
            <h3><i class="fas fa-mobile-alt"></i> Pembayaran via OVO</h3>
            <div class="ewallet-info">
                <p>Silakan transfer ke nomor OVO berikut:</p>
                <div class="ewallet-number">0812 3456 7890</div>
                <button class="btn" style="background: #5f27cd; margin-top: 10px;" onclick="copyToClipboard('081234567890')">Copy Nomor OVO</button>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- COD -->
        <?php if($order['payment_method'] == 'cod'): ?>
        <div class="cod-info">
            <i class="fas fa-motorcycle"></i>
            <h3>Bayar di Tempat (COD)</h3>
            <p>Pesanan Anda akan dikirim dan pembayaran dilakukan saat paket diterima.</p>
            <p style="margin-top: 10px;"><strong>Siapkan uang sebesar:</strong></p>
            <p style="font-size: 1.5rem; font-weight: 700; color: #e74c3c;">Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></p>
        </div>
        <?php endif; ?>
        
        <!-- Tombol -->
        <a href="cetak_invoice.php?id=<?php echo $order['id']; ?>" class="btn" target="_blank">
            <i class="fas fa-print"></i> Cetak Invoice
        </a>
        <a href="lacak_pesanan.php?order_id=<?php echo $order['id']; ?>" class="btn btn-secondary">
            <i class="fas fa-search"></i> Lacak Pesanan
        </a>
        
        <!-- Catatan -->
        <div class="note">
            <i class="fas fa-info-circle"></i>
            <strong>Catatan:</strong> Setelah melakukan pembayaran, pesanan akan diproses. Simpan bukti transfer untuk konfirmasi.
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Nomor berhasil disalin!');
            }, function(err) {
                console.error('Gagal menyalin: ', err);
            });
        }
    </script>

</body>
</html>