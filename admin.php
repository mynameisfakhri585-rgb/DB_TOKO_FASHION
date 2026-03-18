<?php
session_start();
include 'koneksi.php';

// Cek apakah admin login
if(!isset($_SESSION['admin'])) {
    header("Location: login.php?pesan=admin");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; }
        
        /* Sidebar */
        .sidebar { position: fixed; width: 250px; height: 100%; background: #2c3e50; color: white; padding: 20px; }
        .logo { font-size: 1.5rem; font-weight: 700; margin-bottom: 30px; text-align: center; }
        .logo span { color: #e74c3c; }
        
        .menu { list-style: none; }
        .menu li { margin-bottom: 10px; }
        .menu a { display: block; padding: 12px; color: #ddd; text-decoration: none; border-radius: 5px; transition: 0.3s; }
        .menu a:hover, .menu a.active { background: #e74c3c; color: white; }
        
        /* Main Content */
        .main { margin-left: 250px; padding: 30px; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { color: #2c3e50; }
        .btn-logout { padding: 10px 20px; background: #e74c3c; color: white; text-decoration: none; border-radius: 5px; }
        
        /* Cards */
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
        .card h3 { color: #666; font-size: 0.9rem; }
        .card .number { font-size: 2rem; font-weight: 700; color: #2c3e50; margin-top: 10px; }
        
        /* Table */
        .table-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-tambah { padding: 10px 20px; background: #27ae60; color: white; text-decoration: none; border-radius: 5px; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #333; }
        img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
        
        .btn-hapus { padding: 5px 10px; background: #e74c3c; color: white; text-decoration: none; border-radius: 3px; font-size: 0.8rem; }
        
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main { margin-left: 0; }
            .stats { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">ZENITH<span>.</span></div>
        <ul class="menu">
            <li><a href="admin.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="admin_pesanan.php"><i class="fas fa-shopping-cart"></i> Kelola Pesanan</a></li>
            <li><a href="index.php"><i class="fas fa-store"></i> Lihat Website</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main">
        <!-- Tambahkan ini setelah <div class="main"> -->
<?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'edit'): ?>
    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> Produk berhasil diperbarui!
    </div>
<?php endif; ?>
        <div class="header">
            <h1>Dashboard Admin</h1>
            <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        
        <!-- Statistik -->
        <div class="stats">
            <?php
            $produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));
            $pesanan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"));
            $user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role = 'user'"));
            $pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status = 'pending'"));
            ?>
            <div class="card">
                <h3>Total Produk</h3>
                <div class="number"><?php echo $produk; ?></div>
            </div>
            <div class="card">
                <h3>Total Pesanan</h3>
                <div class="number"><?php echo $pesanan; ?></div>
            </div>
            <div class="card">
                <h3>Total User</h3>
                <div class="number"><?php echo $user; ?></div>
            </div>
            <div class="card">
                <h3>Pesanan Pending</h3>
                <div class="number" style="color: #f39c12;"><?php echo $pending; ?></div>
            </div>
        </div>
        
        <!-- Tabel Produk -->
        <div class="table-box">
            <div class="table-header">
                <h2>Kelola Produk</h2>
                <a href="tambah_produk.php" class="btn-tambah"><i class="fas fa-plus"></i> Tambah Produk</a>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Harga Coret</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($query)):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>"></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['old_price'] ? 'Rp ' . number_format($row['old_price'], 0, ',', '.') : '-'; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td>
                          <!-- Ganti bagian Aksi di admin.php dengan ini: -->
<td>
    <a href="edit_produk.php?id=<?php echo $row['id']; ?>" style="background: #3498db; padding: 5px 10px; color: white; text-decoration: none; border-radius: 3px; font-size: 0.8rem; margin-right: 5px;">
        <i class="fas fa-edit"></i> Edit
    </a>
    <a href="hapus_produk.php?id=<?php echo $row['id']; ?>" style="background: #e74c3c; padding: 5px 10px; color: white; text-decoration: none; border-radius: 3px; font-size: 0.8rem;" onclick="return confirm('Yakin hapus produk ini?')">
        <i class="fas fa-trash"></i> Hapus
    </a>
</td>  
                            
                            
                    
                        
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>