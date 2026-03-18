<?php
session_start();
include 'koneksi.php';

if(isset($_SESSION['user'])) {
    header("Location: index.php");
}
if(isset($_SESSION['admin'])) {
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(135deg, #2c3e50, #34495e); height: 100vh; display: flex; justify-content: center; align-items: center; }
        
        .login-box { background: white; padding: 40px; border-radius: 10px; width: 350px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .logo { text-align: center; font-size: 1.8rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px; }
        .logo span { color: #e74c3c; }
        
        h2 { text-align: center; color: #333; margin-bottom: 25px; font-size: 1.2rem; }
        
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        input:focus { outline: 2px solid #2c3e50; border-color: transparent; }
        
        button { width: 100%; padding: 12px; background: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; font-size: 16px; transition: 0.3s; }
        button:hover { background: #e74c3c; }
        
        .link { text-align: center; margin-top: 15px; font-size: 0.9rem; }
        .link a { color: #e74c3c; text-decoration: none; }
        
        .error { background: #ffdddd; color: #d8000c; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem; text-align: center; }
        
        .info { background: #e8f4fd; color: #0d5e8f; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.8rem; text-align: center; }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="logo">ZENITH<span>.</span></div>
        <h2>Login ke Akun Anda</h2>
        
        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
            <div class="error">Email atau password salah!</div>
        <?php endif; ?>
        
        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'belum_login'): ?>
            <div class="error">Silakan login terlebih dahulu!</div>
        <?php endif; ?>

        <div class="info">
            <b>Akun Admin:</b> admin@zenith.com / admin123<br>
            <b>Akun User:</b> Daftar baru di bawah
        </div>

        <form method="POST" action="proses_login.php">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">LOGIN</button>
        </form>
        
        <div class="link">
            Belum punya akun? <a href="register.php">Daftar Sekarang</a>
            <!-- Tambahkan ini di bagian bawah form login: -->
<div class="link">
    Lupa password? <a href="lupa_password.php">Klik di sini</a>
</div>
        </div>
    </div>

</body>
</html>