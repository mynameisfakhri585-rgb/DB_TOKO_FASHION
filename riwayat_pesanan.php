<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; }
        
        .container { max-width: 800px; margin: 100px auto 2rem; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        
        h1 { color: #2c3e50; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #2c3e50; color: white; }
        
        .status-pending { color: #f39c12; font-weight: 600; }
        .status-dikonfirmasi { color: #3498db; font-weight: 600; }
        .status-dikirim { color: #9b59b6; font-weight: 600; }
        .status-selesai { color: #27ae60; font-weight: 600; }
        
        .btn-back { display: inline-block; margin-bottom: 15px; color: #2c3e50; text-decoration: none; }
        .btn-detail { padding: 5px 10px; background: #3498db; color: white; text-decoration: none; border-radius: 3px; font-size: 0.8rem; }
        
        .empty { text-align: center; padding: 30px; color: #666; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="btn-back">← Kembali ke Toko</a>
    <h1>Riwayat Pesanan Anda</h1>
    
    <table>
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $user_id = $_SESSION['id_user'];
            $query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC");
            
            if(mysqli_num_rows($query) > 0):
                while($row = mysqli_fetch_assoc($query)):
            ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo date('d M Y', strtotime($row['tanggal_pesan'])); ?></td>
                <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td class="status-<?php echo $row['status']; ?>">
                    <?php echo ucfirst($row['status']); ?>
                </td>
                <td>
                    <a href="detail_pesanan.php?id=<?php echo $row['id']; ?>" class="btn-detail">Lihat Detail</a>
                </td>
            </tr>
            <?php 
                endwhile;
            else:
            ?>
            <tr>
                <td colspan="5" class="empty">Belum ada riwayat pesanan.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>