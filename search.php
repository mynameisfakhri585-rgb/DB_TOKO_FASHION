<?php
session_start();
include 'koneksi.php';

$search = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';

$query = "SELECT * FROM products WHERE name LIKE '%$search%' OR category LIKE '%$search%' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Sama seperti style produk di index.php */
        body { font-family: 'Poppins', sans-serif; background: #f9f9f9; padding: 80px 5% 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { color: #2c3e50; margin-bottom: 20px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem; }
        .product-card { background: white; border-radius: 8px; overflow: hidden; transition: 0.3s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .product-img { height: 250px; width: 100%; object-fit: cover; }
        .product-info { padding: 1rem; }
        .product-title { font-weight: 600; margin-bottom: 0.5rem; }
        .product-price { color: #e74c3c; font-weight: 700; }
        .btn-buy { display: block; padding: 10px; background: #2c3e50; color: white; text-align: center; margin-top: 10px; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h1>Hasil Pencarian: "<?php echo $search; ?>"</h1>
    <p>Ditemukan <?php echo mysqli_num_rows($result); ?> produk</p>
    <br>
    
    <div class="product-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="product-card">
            <img src="<?php echo $row['image']; ?>" class="product-img">
            <div class="product-info">
                <h3 class="product-title"><?php echo $row['name']; ?></h3>
                <p class="product-price">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                <a href="tambah_keranjang.php?id=<?php echo $row['id']; ?>" class="btn-buy">Tambah ke Keranjang</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>