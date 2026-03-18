<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
    header("Location: login.php");
}

// Ambil data user dari database
$user_id = $_SESSION['id_user'];
$query_user = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($query_user);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; }
        
        .container { max-width: 800px; margin: 100px auto 2rem; padding: 20px; }
        
        .profile-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden; }
        
        .profile-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            padding: 40px;
            text-align: center;
            color: white;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
        }
        .profile-header h1 { font-size: 1.5rem; margin-bottom: 5px; }
        .profile-header p { opacity: 0.8; }
        
        .profile-body { padding: 30px; }
        
        .info-row { display: flex; padding: 15px 0; border-bottom: 1px solid #eee; }
        .info-label { width: 150px; font-weight: 600; color: #666; }
        .info-value { flex: 1; color: #333; }
        
        .btn-group { display: flex; gap: 10px; margin-top: 25px; }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }
        .btn-primary { background: #2c3e50; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn:hover { opacity: 0.9; }
        
        .btn-back { display: inline-block; margin-bottom: 15px; color: #666; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Toko</a>
    
    <div class="profile-card">
        <!-- Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
            </div>
            <h1><?php echo $user['name']; ?></h1>
            <p><?php echo $user['email']; ?></p>
        </div>
        
        <!-- Body -->
        <div class="profile-body">
            <div class="info-row">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-value"><?php echo $user['name']; ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value"><?php echo $user['email']; ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Akun</span>
                <span class="info-value" style="color: #27ae60; font-weight: 600;">Aktif</span>
            </div>
            <div class="info-row">
                <span class="info-label">Bergabung</span>
                <span class="info-value"><?php echo date('d M Y', strtotime($user['created_at'])); ?></span>
            </div>
            
            <div class="btn-group">
                <a href="edit_profil.php" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Profil</a>
                <a href="riwayat_pesanan.php" class="btn btn-success"><i class="fas fa-shopping-bag"></i> Riwayat Pesanan</a>
                <a href="logout.php" class="btn btn-danger" onclick="return confirm('Yakin logout?')"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>