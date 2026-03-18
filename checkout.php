<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0) {
    echo "<script>alert('Keranjang kosong!'); window.location.href='index.php';</script>";
    exit;
}

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
    header("Location: login.php?pesan=checkout");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; }
        
        .container { max-width: 1000px; margin: 100px auto 2rem; padding: 0 20px; }
        
        h1 { color: #2c3e50; margin-bottom: 20px; }
        h2 { font-size: 1.1rem; color: #333; margin-bottom: 15px; border-bottom: 2px solid #e74c3c; padding-bottom: 10px; }
        
        .checkout-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        
        .form-box { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-size: 0.9rem; color: #555; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        
        /* Payment Method Styles */
        .payment-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px; }
        .payment-option {
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: 0.3s;
        }
        .payment-option:hover { border-color: #3498db; }
        .payment-option.selected { border-color: #27ae60; background: #f0fff4; }
        .payment-option i { font-size: 1.5rem; margin-bottom: 5px; display: block; color: #2c3e50; }
        .payment-option input { display: none; }
        
        .summary-box { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        
        .product-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .product-item img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; margin-right: 10px; }
        .product-item .info { flex: 1; }
        .product-item .price { font-weight: 600; color: #e74c3c; }
        
        .total-row { display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700; margin-top: 20px; padding-top: 15px; border-top: 2px solid #eee; }
        
        .btn-checkout { width: 100%; padding: 15px; background: #27ae60; color: white; border: none; border-radius: 5px; font-size: 1rem; font-weight: 600; cursor: pointer; margin-top: 20px; transition: 0.3s; }
        .btn-checkout:hover { background: #219150; }
        .btn-back { display: inline-block; margin-bottom: 15px; color: #666; }

        @media (max-width: 768px) {
            .checkout-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="keranjang.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Keranjang</a>
    <h1>Checkout Pesanan</h1>
    
    <div class="checkout-grid">
        
        <!-- Form Data & Pembayaran -->
        <div class="form-box">
            <h2><i class="fas fa-user"></i> Data Pemesan</h2>
            <form method="POST" action="proses_checkout.php">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" value="<?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="telepon" placeholder="0812xxxxxxx" required>
                </div>
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" placeholder="Jl. nama jalan, Rt/Rw, Kota, Kode Pos" required></textarea>
                </div>
                
                <!-- Metode Pembayaran -->
                <h2 style="margin-top: 25px;"><i class="fas fa-credit-card"></i> Metode Pembayaran</h2>
                
                <div class="payment-methods">
                    <label class="payment-option selected">
                        <input type="radio" name="payment_method" value="transfer_bank" checked>
                        <i class="fas fa-university"></i>
                        <strong>Transfer Bank</strong>
                        <small style="display:block; color:#666; font-size:0.75rem;">BCA, BRI, Mandiri</small>
                    </label>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="dana">
                        <i class="fas fa-wallet"></i>
                        <strong>DANA</strong>
                        <small style="display:block; color:#666; font-size:0.75rem;">Bayar via DANA</small>
                    </label>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="ovo">
                        <i class="fas fa-mobile-alt"></i>
                        <strong>OVO</strong>
                        <small style="display:block; color:#666; font-size:0.75rem;">Bayar via OVO</small>
                    </label>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod">
                        <i class="fas fa-motorcycle"></i>
                        <strong>COD</strong>
                        <small style="display:block; color:#666; font-size:0.75rem;">Bayar di tempat</small>
                    </label>
                </div>
        </div>
        
        <!-- Ringkasan Pesanan -->
        <div class="summary-box">
            <h2><i class="fas fa-shopping-bag"></i> Ringkasan Pesanan</h2>
            
            <?php 
            $total = 0;
            foreach($_SESSION['keranjang'] as $id => $item):
                $subtotal = $item['harga'] * $item['qty'];
                $total += $subtotal;
            ?>
            <div class="product-item">
                <div style="display:flex; align-items:center;">
                    <img src="<?php echo $item['gambar']; ?>">
                    <div class="info">
                        <strong><?php echo $item['nama']; ?></strong><br>
                        <small><?php echo $item['qty']; ?> x Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></small>
                    </div>
                </div>
                <div class="price">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></div>
            </div>
            <?php endforeach; ?>
            
            <div class="total-row">
                <span>Total Pembayaran</span>
                <span style="color: #e74c3c;">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
            </div>
            
            <input type="hidden" name="total_harga" value="<?php echo $total; ?>">
            <button type="submit" class="btn-checkout" onclick="return confirm('Konfirmasi pesanan sekarang?')">
                <i class="fas fa-check-circle"></i> KONFIRMASI PESANAN
            </button>
            </form>
        </div>
        
    </div>
</div>

<script>
    // Script untuk pilih metode pembayaran
    const options = document.querySelectorAll('.payment-option');
    options.forEach(option => {
        option.addEventListener('click', function() {
            options.forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input').checked = true;
        });
    });
</script>

</body>
</html>