<?php
session_start();
include 'koneksi.php';

// Cek apakah ada pencarian
$search = "";
$where = "";

if(isset($_GET['search']) && $_GET['search'] != "") {
    $search = htmlspecialchars($_GET['search']);
    $where = "WHERE name LIKE '%$search%' OR category LIKE '%$search%'";
}

$query = "SELECT * FROM products $where ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenith Fashion - Toko Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #e74c3c;
            --bg-light: #f9f9f9;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-light); color: #333; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        /* Search Form Styles */
.search-form input {
    transition: 0.3s;
}
.search-form input:focus {
    outline: none;
    border-color: var(--accent-color);
    width: 180px;
}

/* Search Results Info */
.search-info {
    text-align: center;
    padding: 20px;
    background: white;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.search-info h3 {
    color: #2c3e50;
    margin-bottom: 5px;
}
.search-info a {
    color: #e74c3c;
    text-decoration: none;
}

        /* HEADER */
        header { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: fixed; width: 100%; top: 0; z-index: 1000; }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo { font-size: 1.5rem; font-weight: 700; color: var(--primary-color); }

        .nav-links { display: flex; gap: 2rem; }
        .nav-links a { font-weight: 500; transition: 0.3s; }
        .nav-links a:hover { color: var(--accent-color); }

        .nav-icons { display: flex; align-items: center; gap: 1rem; font-size: 1.2rem; }

        /* USER MENU DROPDOWN */
        .user-dropdown { position: relative; }
        .user-btn { 
            display: flex; align-items: center; gap: 8px; 
            padding: 5px 10px; border-radius: 20px; 
            background: #f0f0f0; cursor: pointer; 
            font-size: 0.9rem; font-weight: 500;
        }
        .user-btn img { width: 30px; height: 30px; border-radius: 50%; object-fit: cover; }
        .user-avatar { 
            width: 30px; height: 30px; border-radius: 50%; 
            background: var(--primary-color); color: white; 
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 40px;
            background: white;
            min-width: 180px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            overflow: hidden;
            z-index: 1001;
        }
        .dropdown-content a {
            display: block;
            padding: 12px 15px;
            color: #333;
            font-size: 0.9rem;
            transition: 0.2s;
        }
        .dropdown-content a:hover { background: #f9f9f9; color: var(--accent-color); }
        .dropdown-content a i { margin-right: 8px; width: 20px; }
        
        .user-dropdown:hover .dropdown-content { display: block; }

        /* HERO */
        .hero {
            height: 80vh;
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 60px;
        }
        .hero h1 { font-size: 3.5rem; margin-bottom: 1rem; }
        .hero p { font-size: 1.2rem; margin-bottom: 2rem; }
        .btn-cta {
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 5px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-cta:hover { background-color: var(--accent-color); }

        /* PRODUCTS */
        .products { padding: 5rem 5%; max-width: 1200px; margin: 0 auto; }
        .section-title { text-align: center; font-size: 2rem; margin-bottom: 3rem; color: var(--primary-color); }
        
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem; }
        .product-card { background: white; border: 1px solid #eee; border-radius: 8px; overflow: hidden; transition: 0.3s; }
        .product-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.1); transform: translateY(-5px); }
        .product-img { height: 250px; width: 100%; object-fit: cover; }
        .product-info { padding: 1rem; }
        .product-title { font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; }
        .product-price { color: var(--accent-color); font-weight: 700; font-size: 1.1rem; }
        .old-price { text-decoration: line-through; color: #999; font-size: 0.9rem; margin-right: 10px; }
        .btn-buy {
            display: block;
            width: 100%;
            padding: 10px;
            background: var(--primary-color);
            color: white;
            border: none;
            margin-top: 1rem;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
            text-align: center;
            border-radius: 5px;
        }
        .btn-buy:hover { background: var(--accent-color); }

        /* FOOTER */
        footer { background: #222; color: #aaa; padding: 2rem; text-align: center; margin-top: 3rem; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.2rem; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header>
        <nav class="navbar">
            <div class="logo">ZENITH<span style="color:var(--accent-color)">.</span></div>
            
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="#produk">Koleksi</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
            
           <!-- Ganti bagian nav-icons di index.php dengan ini: -->
<div class="nav-icons">
    <!-- Form Search -->
    <form method="GET" action="index.php" class="search-form" style="display:flex; align-items:center; gap:5px; margin-right: 15px;">
        <input type="text" name="search" placeholder="Cari produk..." 
               style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 20px; font-size: 0.85rem; width: 150px;">
        <button type="submit" style="background:none; border:none; cursor:pointer; color:#333;">
            <i class="fas fa-search"></i>
        </button>
    </form>
    
   
    
    <?php if(isset($_SESSION['user'])): ?>
        <!-- User Login -->
        <div class="user-dropdown">
            <div class="user-btn">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($_SESSION['nama'], 0, 1)); ?>
                </div>
                <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
            </div>
            <div class="dropdown-content">
                <a href="profil.php"><i class="fas fa-user"></i> Profil Saya</a>
                <a href="riwayat_pesanan.php"><i class="fas fa-shopping-bag"></i> Riwayat Pesanan</a>
                <a href="keranjang.php"><i class="fas fa-shopping-cart"></i> Keranjang</a>
                <a href="logout.php" style="color: var(--accent-color);"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    <?php elseif(isset($_SESSION['admin'])): ?>
        <a href="admin.php"><i class="fas fa-cog"></i></a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
    <?php else: ?>
        <a href="login.php"><i class="fas fa-user"></i></a>
        <a href="keranjang.php"><i class="fas fa-shopping-cart"></i></a>
    <?php endif; ?>
</div>
            </div>
        </nav>
    </header>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-content">
            <h1>Tampil Keren Setiap Hari</h1>
            <p>Koleksi terbaru fashion Pria & Wanita dengan kualitas premium.</p>
            <a href="#produk" class="btn-cta">Belanja Sekarang</a>
        </div>
    </section>

    <!-- PRODUCTS SECTION -->
    <!-- PRODUCTS SECTION -->
<section class="products" id="produk">
    
    <!-- Info Hasil Pencarian -->
    <?php if(isset($_GET['search']) && $_GET['search'] != ""): ?>
        <div class="search-info">
            <h3>Hasil Pencarian untuk: "<?php echo $_GET['search']; ?>"</h3>
            <p>Ditemukan <?php echo mysqli_num_rows($result); ?> produk</p>
            <a href="index.php"><i class="fas fa-times"></i> Hapus filter</a>
        </div>
    <?php else: ?>
        <h2 class="section-title">Koleksi Terbaru</h2>
    <?php endif; ?>
    
    <div class="product-grid">
        <?php 
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="product-card">
                <img src="<?php echo $row['image']; ?>" class="product-img" alt="<?php echo $row['name']; ?>">
                <div class="product-info">
                    <h3 class="product-title"><?php echo $row['name']; ?></h3>
                    <p>
                        <?php if($row['old_price']): ?>
                            <span class="old-price">Rp <?php echo number_format($row['old_price'], 0, ',', '.'); ?></span>
                        <?php endif; ?>
                        <span class="product-price">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></span>
                    </p>
                    <a href="tambah_keranjang.php?id=<?php echo $row['id']; ?>" class="btn-buy">Tambah ke Keranjang</a>
                </div>
            </div>
        <?php 
            }
        } else {
        ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                <i class="fas fa-search" style="font-size: 3rem; color: #ccc; margin-bottom: 15px;"></i>
                <p>Produk tidak ditemukan.</p>
                <a href="index.php" style="color: #e74c3c;">Kembali ke semua produk</a>
            </div>
        <?php 
        }
        ?>
    </div>
</section>

    <!-- FOOTER -->
   <footer id="kontak" style="background: #222; color: #aaa; padding: 3rem 5%; margin-top: 3rem;">
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
        
        <!-- Kolom 1: Tentang -->
        <div>
            <h3 style="color: white; margin-bottom: 1rem;">ZENITH<span style="color: #e74c3c;">.</span></h3>
            <p style="font-size: 0.9rem; line-height: 1.6;">
                Toko fashion online terpercaya dengan koleksi terbaru dan kualitas premium untuk pria dan wanita.
            </p>
        </div>
        
        <!-- Kolom 2: Link Cepat -->
        <div>
            <h4 style="color: white; margin-bottom: 1rem;">Link Cepat</h4>
            <ul style="list-style: none; padding: 0;">
                <li style="margin-bottom: 8px;"><a href="index.php" style="color: #aaa; text-decoration: none;">Beranda</a></li>
                <li style="margin-bottom: 8px;"><a href="#produk" style="color: #aaa; text-decoration: none;">Koleksi</a></li>
                <li style="margin-bottom: 8px;"><a href="lacak_pesanan.php" style="color: #aaa; text-decoration: none;">Lacak Pesanan</a></li>
                <li style="margin-bottom: 8px;"><a href="login.php" style="color: #aaa; text-decoration: none;">Login</a></li>
            </ul>
        </div>
        
        <!-- Kolom 3: Kategori -->
        <div>
            <h4 style="color: white; margin-bottom: 1rem;">Kategori</h4>
            <ul style="list-style: none; padding: 0;">
                <li style="margin-bottom: 8px;"><a href="#produk" style="color: #aaa; text-decoration: none;">Fashion Pria</a></li>
                <li style="margin-bottom: 8px;"><a href="#produk" style="color: #aaa; text-decoration: none;">Fashion Wanita</a></li>
                <li style="margin-bottom: 8px;"><a href="#produk" style="color: #aaa; text-decoration: none;">Aksesoris</a></li>
            </ul>
        </div>
        
        <!-- Kolom 4: Hubungi -->
        <div>
            <h4 style="color: white; margin-bottom: 1rem;">Hubungi Kami</h4>
            <p style="font-size: 0.9rem; margin-bottom: 8px;">
                <i class="fas fa-envelope"></i> admin@zenith.com
            </p>
            <p style="font-size: 0.9rem; margin-bottom: 8px;">
                <i class="fas fa-phone"></i> +62 812 3456 7890
            </p>
            <p style="font-size: 0.9rem;">
                <i class="fas fa-map-marker-alt"></i> Bekasi, Indonesia
            </p>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #333;">
        <p>&copy; 2026 Zenith Fashion. All rights reserved.</p>
    </div>
</footer>

</body>
</html>