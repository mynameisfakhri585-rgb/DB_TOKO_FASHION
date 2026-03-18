<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['admin'])) {
    header("Location: login.php?pesan=admin");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan - Admin Zenith</title>
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
        
        .table-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow-x: auto; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #333; font-size: 0.9rem; }
        
        .status { padding: 5px 10px; border-radius: 3px; font-size: 0.75rem; font-weight: 600; }
        .status-pending { background: #f39c12; color: white; }
        .status-dikonfirmasi { background: #3498db; color: white; }
        .status-dikirim { background: #9b59b6; color: white; }
        .status-selesai { background: #27ae60; color: white; }
        
        .btn-detail { 
            padding: 6px 12px; 
            background: #3498db; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 0.8rem;
            display: inline-block;
        }
        
        /* Form Update Status */
        .status-form { display: flex; gap: 5px; align-items: center; }
        .status-select {
            padding: 5px 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.8rem;
            background: white;
            cursor: pointer;
        }
        .status-select:focus { outline: 2px solid #2c3e50; }
        
        .btn-update {
            padding: 5px 10px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
        }
        .btn-update:hover { background: #219150; }
        
        /* Filter */
        .filter { margin-bottom: 20px; display: flex; gap: 10px; align-items: center; }
        .filter label { font-size: 0.9rem; color: #666; }
        .filter select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        /* Alert */
        .alert { 
            padding: 12px 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            font-size: 0.9rem; 
        }
        .alert-success { background: #d4edda; color: #155724; }
        
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">ZENITH<span>.</span></div>
        <ul class="menu">
            <li><a href="admin.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="admin_pesanan.php" class="active"><i class="fas fa-shopping-cart"></i> Kelola Pesanan</a></li>
            <li><a href="index.php"><i class="fas fa-store"></i> Lihat Website</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main">
        <div class="header">
            <h1>Kelola Pesanan</h1>
        </div>
        
        <!-- Alert Sukses -->
        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'update'): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> Status pesanan berhasil diperbarui!
            </div>
        <?php endif; ?>
        
        <!-- Filter Status -->
        <div class="table-box">
            <div class="filter">
                <label>Filter Status:</label>
                <form method="GET" style="display:inline;">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" <?php if(isset($_GET['status']) && $_GET['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="dikonfirmasi" <?php if(isset($_GET['status']) && $_GET['status'] == 'dikonfirmasi') echo 'selected'; ?>>Dikonfirmasi</option>
                        <option value="dikirim" <?php if(isset($_GET['status']) && $_GET['status'] == 'dikirim') echo 'selected'; ?>>Dikirim</option>
                        <option value="selesai" <?php if(isset($_GET['status']) && $_GET['status'] == 'selesai') echo 'selected'; ?>>Selesai</option>
                    </select>
                </form>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pesanan</th>
                        <th>Pemesan</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Filter query
                    $where = "";
                    if(isset($_GET['status']) && $_GET['status'] != "") {
                        $status = $_GET['status'];
                        $where = "WHERE status = '$status'";
                    }
                    
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM orders $where ORDER BY id DESC");
                    
                    if(mysqli_num_rows($query) > 0):
                        while($row = mysqli_fetch_assoc($query)):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><strong>#<?php echo $row['id']; ?></strong></td>
                        <td>
                            <strong><?php echo $row['nama_pemesan']; ?></strong><br>
                            <small style="color: #666;"><?php echo $row['telepon']; ?></small>
                        </td>
                        <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tanggal_pesan'])); ?></td>
                        <td>
                            <span class="status status-<?php echo $row['status']; ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </td>
                        <td>
                            <!-- Form Ubah Status -->
                            <form method="POST" action="admin_update_status.php" class="status-form">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <select name="status" class="status-select">
                                    <option value="" selected disabled>Ubah</option>
                                    <option value="pending">Pending</option>
                                    <option value="dikonfirmasi">Dikonfirmasi</option>
                                    <option value="dikirim">Dikirim</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                                <button type="submit" class="btn-update" onclick="return confirm('Update status pesanan ini?')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            
                            <!-- Tombol Detail -->
                            <a href="admin_detail_pesanan.php?id=<?php echo $row['id']; ?>" class="btn-detail" style="margin-top: 5px; display: inline-block;">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #666;">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                            Tidak ada pesanan.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>