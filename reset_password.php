<?php
include 'koneksi.php';

$token = isset($_GET['token']) ? $_GET['token'] : '';

// Validasi token kosong
if(empty($token)) {
    echo "<script>alert('Token kosong!'); window.location.href='login.php';</script>";
    exit;
}

// Cek token di database - HAPUS kondisi expire dulu untuk debug
$query = mysqli_query($conn, "SELECT * FROM users WHERE reset_token = '$token'");
$user = mysqli_fetch_assoc($query);

if(!$user) {
    echo "<script>alert('Token tidak valid! Token: $token'); window.location.href='login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2c3e50, #34495e); height: 100vh; display: flex; justify-content: center; align-items: center; }
        .box { background: white; padding: 40px; border-radius: 10px; width: 350px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #27ae60; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; }
        .link { text-align: center; margin-top: 15px; }
        .link a { color: #666; text-decoration: none; }
    </style>
</head>
<body>

<div class="box">
    <h2>Reset Password</h2>
    <p style="text-align:center; margin-bottom:20px;">Halo <b><?php echo $user['name']; ?></b>, masukkan password baru:</p>
    
    <form method="POST" action="simpan_password.php">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <input type="password" name="password_baru" placeholder="Password Baru" required minlength="6">
        <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password" required>
        <button type="submit">SIMPAN PASSWORD</button>
    </form>
    
    <div class="link">
        <a href="login.php">← Kembali</a>
    </div>
</div>

</body>
</html>