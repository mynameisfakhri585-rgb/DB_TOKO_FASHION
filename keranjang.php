<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #e74c3c;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f9f9f9; }
        
        .container { max-width: 1000px; margin: 100px auto 2rem; padding: 0 20px; }
        h1 { color: var(--primary); margin-bottom: 2rem; }
        
        .cart-table { width: 100%; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .cart-table th, .cart-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .cart-table th { background: var(--primary); color: white; }
        .cart-img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; }
        .qty-btn { padding: 5px 10px; background: #eee; border: none; cursor: pointer; }
        
        .total-box { background: white; padding: 20px; margin-top: 2rem; border-radius: 8px; text-align: right; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .total-price { font-size: 1.5rem; color: var(--accent); font-weight: 700; }
        .btn-checkout { display: inline-block; margin-top: 1rem; padding: 10px 30px; background: var(--accent); color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; }
        .btn-back { display: inline-block; margin-bottom: 1rem; color: var(--primary); }
        
        .empty { text-align: center; padding: 3rem; }
    </style>
</head>
<body>

    <div class="container">
        <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Toko</a>
        <h1>Keranjang Belanja</h1>

        <?php if(isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0): ?>
        
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach($_SESSION['keranjang'] as $id => $item):
                    $subtotal = $item['harga'] * $item['qty'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><img src="<?php echo $item['gambar']; ?>" class="cart-img" alt="<?php echo $item['nama']; ?>"></td>
                    <td><?php echo $item['nama']; ?></td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="ubah_qty.php?id=<?php echo $id; ?>&act=kurang" class="qty-btn">-</a>
                        <span style="margin: 0 10px;"><?php echo $item['qty']; ?></span>
                        <a href="ubah_qty.php?id=<?php echo $id; ?>&act=tambah" class="qty-btn">+</a>
                    </td>
                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    <td><a href="hapus_keranjang.php?id=<?php echo $id; ?>" style="color: red;"><i class="fas fa-trash"></i></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-box">
            <p>Total Belanja: <span class="total-price">Rp <?php echo number_format($total, 0, ',', '.'); ?></span></p>
            <?php if(isset($_SESSION['user']) || isset($_SESSION['admin'])): ?>
    <a href="checkout.php" class="btn-checkout">Checkout Sekarang</a>
<?php else: ?>
    <a href="login.php?pesan=checkout" class="btn-checkout" style="background: #3498db; text-align:center; display:block; padding: 15px; border-radius:5px; color:white; text-decoration:none; margin-top:20px;">Login untuk Checkout</a>
<?php endif; ?>
<!-- Tambahkan link lacak pesanan -->
<div style="margin-top: 15px; text-align: center;">
    <a href="lacak_pesanan.php" style="color: #3498db; font-size: 0.9rem;">
        <i class="fas fa-search"></i> Lacak Pesanan Anda
    </a>
</div>
        </div>

        <?php else: ?>
            <div class="empty">
                <i class="fas fa-shopping-cart" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                <p>Keranjang kamu masih kosong.</p>
                <a href="index.php" style="color: var(--accent);">Silahkan Belanja Dulu</a>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>