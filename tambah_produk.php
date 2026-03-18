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
    <title>Tambah Produk - Admin Zenith</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        
        .form-box { background: white; padding: 40px; border-radius: 10px; width: 100%; max-width: 500px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        
        h1 { color: #2c3e50; margin-bottom: 30px; text-align: center; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .form-group input:focus, .form-group select:focus { outline: 2px solid #2c3e50; border-color: transparent; }
        
        .btn-submit { width: 100%; padding: 15px; background: #27ae60; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background: #219150; }
        
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #666; }
        
        .info { background: #e8f4fd; color: #0d5e8f; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 0.85rem; }
    </style>
</head>
<body>

    <div class="form-box">
        <h1>Tambah Produk Baru</h1>
        
        <div class="info">
            💡 Tips: Gunakan link gambar dari Google Images atau Unsplash untuk kolom gambar.
        </div>
        
        <form method="POST" action="proses_tambah.php">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama" placeholder="Contoh: Kaos Polos Hitam" required>
            </div>
            
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" placeholder="Contoh: 75000" required>
            </div>
            
            <div class="form-group">
                <label>Harga Coret / Diskon (Rp) - Opsional</label>
                <input type="number" name="harga_lama" placeholder="Contoh: 100000">
            </div>
            
            <div class="form-group">
                <label>URL Gambar</label>
                <input type="text" name="gambar" placeholder="https://..." required>
            </div>
            
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="Anak">Anak</option>
                </select>
            </div>
            
            <button type="submit" class="btn-submit">SIMPAN PRODUK</button>
            <a href="admin.php" class="btn-back">← Kembali ke Dashboard</a>
        </form>
    </div>

</body>
</html>