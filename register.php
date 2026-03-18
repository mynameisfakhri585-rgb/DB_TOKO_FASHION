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
    <title>Register - Zenith Fashion</title>
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
        
        button { width: 100%; padding: 12px; background: #27ae60; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; font-size: 16px; transition: 0.3s; }
        button:hover { background: #219150; }
        
        .link { text-align: center; margin-top: 15px; font-size: 0.9rem; }
        .link a { color: #e74c3c; text-decoration: none; }
        
        .error { background: #ffdddd; color: #d8000c; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem; text-align: center; }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="logo">ZENITH<span>.</span></div>
        <h2>Daftar Akun Baru</h2>
        
        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
            <div class="error">Email sudah terdaftar!</div>
        <?php endif; ?>

        <form method="POST" action="proses_register.php">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="warna_keamanan" placeholder="Warna Favorit (Untuk Keamanan)" required>
            <button type="submit">DAFTAR</button>
        </form>
        
        <div class="link">
            Sudah punya akun? <a href="login.php">Login Sekarang</a>
        </div>
    </div>

</body>
</html>