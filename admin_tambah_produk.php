<?php include '../koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f4f4; display: flex; justify-content: center; padding-top: 50px; }
        .form-box { background: white; padding: 30px; border-radius: 8px; width: 400px; }
        h2 { color: #2c3e50; margin-bottom: 20px; }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 100%; padding: 10px; background: #27ae60; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Tambah Produk Baru</h2>
        <form method="POST" action="proses_tambah.php">
            <input type="text" name="nama" placeholder="Nama Produk" required>
            <input type="number" name="harga" placeholder="Harga (Rp)" required>
            <input type="number" name="harga_lama" placeholder="Harga Lama (Opsional)">
            <input type="text" name="gambar" placeholder="URL Gambar (Link)" required>
            <select name="kategori">
                <option value="Pria">Pria</option>
                <option value="Wanita">Wanita</option>
                <option value="Aksesoris">Aksesoris</option>
            </select>
            <button type="submit" name="submit">Simpan Produk</button>
        </form>
    </div>
</body>
</html>