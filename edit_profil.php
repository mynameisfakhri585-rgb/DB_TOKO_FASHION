<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['id_user'];
$query_user = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($query_user);

// Proses update profil
if(isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Jika password diisi, update juga password
    if($password != "") {
        $query = "UPDATE users SET name = '$nama', email = '$email', password = '$password' WHERE id = $user_id";
    } else {
        $query = "UPDATE users SET name = '$nama', email = '$email' WHERE id = $user_id";
    }
    
    if(mysqli_query($conn, $query)) {
        // Update session
        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;
        
        echo "<script>
                alert('Profil berhasil diperbarui!');
                window.location.href = 'profil.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui profil!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Zenith Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        
        .form-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        h1 { color: #2c3e50; margin-bottom: 10px; text-align: center; }
        p.subtitle { text-align: center; color: #666; margin-bottom: 30px; font-size: 0.9rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; font-size: 0.9rem; }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }
        .form-group input:focus { outline: 2px solid #2c3e50; border-color: transparent; }
        
        .form-group small { color: #666; font-size: 0.8rem; display: block; margin-top: 5px; }
        
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-submit:hover { background: #219150; }
        
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #666;
            text-decoration: none;
        }
        .btn-back:hover { color: #2c3e50; }
        
        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

    <div class="form-box">
        <h1><i class="fas fa-user-edit"></i> Edit Profil</h1>
        <p class="subtitle">Perbarui data diri Anda</p>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?php echo $user['name']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah">
                <small>Isi jika ingin mengganti password</small>
            </div>
            
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="konfirmasi_password" placeholder="Masukkan password baru lagi">
            </div>
            
            <button type="submit" name="submit" class="btn-submit" onclick="return confirm('Simpan perubahan profil?')">
                <i class="fas fa-save"></i> SIMPAN PERUBAHAN
            </button>
            
            <a href="profil.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Profil</a>
        </form>
    </div>

</body>
</html>