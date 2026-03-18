<?php
session_start();
include 'koneksi.php';

if(isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(135deg, #2c3e50, #34495e); height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }
        
        .login-box { background: white; padding: 40px; border-radius: 10px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .logo { text-align: center; font-size: 1.8rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px; }
        .logo span { color: #e74c3c; }
        
        h2 { text-align: center; color: #333; margin-bottom: 10px; font-size: 1.2rem; }
        p { text-align: center; color: #666; margin-bottom: 25px; font-size: 0.9rem; }
        
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        input:focus { outline: 2px solid #2c3e50; border-color: transparent; }
        
        button { width: 100%; padding: 12px; background: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; font-size: 16px; transition: 0.3s; }
        button:hover { background: #e74c3c; }
        
        .link { text-align: center; margin-top: 15px; font-size: 0.9rem; }
        .link a { color: #e74c3c; text-decoration: none; }
        
        .error { background: #ffdddd; color: #d8000c; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem; text-align: center; }
        .success { background: #ddffdd; color: #270; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem; text-align: center; }
        
        .icon { text-align: center; font-size: 3rem; color: #2c3e50; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="logo">ZENITH<span>.</span></div>

    <div class="login-box">
        <div class="icon"><i class="fas fa-key"></i></div>
        <h2>Lupa Password?</h2>
        <p>Masukkan email Anda untuk menerima link reset password.</p>
        
        <?php if(isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="error">Email tidak ditemukan!</div>
        <?php endif; ?>
        
        <?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="success">Link reset password telah dikirim ke email Anda!</div>
        <?php endif; ?>

        <form method="POST" action="proses_otp_request.php">
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="text" name="warna" placeholder="Apa warna keamanan Anda?" required>
    <button type="submit">MINTA KODE VERIFIKASI</button>
</form>
        <div class="link">
            <a href="login.php">← Kembali ke Login</a>
        </div>
    </div>

</body>
</html>