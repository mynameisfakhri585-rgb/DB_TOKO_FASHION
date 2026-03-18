<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['admin'])) {
    header("Location: login.php?pesan=admin");
    exit;
}

$id = $_GET['id'];

// Ambil data produk
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

if(!$produk) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location.href='admin.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin Zenith</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        
        .form-box { background: white; padding: 40px; border-radius: 10px; width: 100%; max-width: 500px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        
        h1 { color: #2c3e50; margin-bottom: 30px; text-align: center; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .form-group input:focus { outline: 2px solid #2c3e50; border-color: transparent; }
        
        .preview-img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; }
        
        .btn-submit { width: 100%; padding: 15px; background: #3498db; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background: #2980b9; }
        
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #666; }
    </style>
</head>
<body>

    <div class="form-box">
        <h1><i class="fas fa-edit"></i> Edit Produk</h1>
        
        <!-- Preview Gambar -->
        <img src="<?php echo $produk['image']; ?>" class="preview-img" alt="<?php echo $produk['name']; ?>">
        
        <form method="POST" action="proses_edit_produk.php">
            <input type="hidden" name="id" value="<?php echo $produk['id']; ?>">
            
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama" value="<?php echo $produk['name']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" value="<?php echo $produk['price']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Harga Coret / Diskon (Rp) - Opsional</label>
                <input type="number" name="harga_lama" value="<?php echo $produk['old_price']; ?>" placeholder="Kosongkan jika tidak ada diskon">
            </div>
            
            <div class="form-group">
                <label>URL Gambar</label>
                <input type="text" name="gambar" value="<?php echo $produk['image']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="Pria" <?php if($produk['category'] == 'Pria') echo 'selected'; ?>>Pria</option>
                    <option value="Wanita" <?php if($produk['category'] == 'Wanita') echo 'selected'; ?>>Wanita</option>
                    <option value="Aksesoris" <?php if($produk['category'] == 'Aksesoris') echo 'selected'; ?>>Aksesoris</option>
                    <option value="Anak" <?php if($produk['category'] == 'Anak') echo 'selected'; ?>>Anak</option>
                </select>
            </div>
            
            <button type="submit" class="btn-submit" onclick="return confirm('Simpan perubahan produk?')">
                <i class="fas fa-save"></i> SIMPAN PERUBAHAN
            </button>
            
            <a href="admin.php" class="btn-back">← Kembali ke Dashboard</a>
        </form>
    </div>

</body>
</html>