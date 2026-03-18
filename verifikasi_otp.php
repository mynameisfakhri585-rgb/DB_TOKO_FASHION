<?php
session_start();
if(!isset($_SESSION['reset_email'])) { header("Location: lupa_password.php"); exit; }
?>
<div class="login-box">
    <h2>Verifikasi OTP</h2>
    <p>Masukkan kode 6-digit. Berlaku 2 menit.</p>
    
    <form method="POST" action="proses_verifikasi_2fa.php">
        <input type="text" name="otp" maxlength="6" placeholder="000000" style="text-align:center; font-size:24px; letter-spacing:8px;" required>
        <button type="submit">VERIFIKASI & GANTI PASSWORD</button>
    </form>

    <form method="POST" action="hapus_notifikasi.php" style="margin-top:10px;">
        <button type="submit" style="background:#95a5a6;">HAPUS NOTIFIKASI & BATAL</button>
    </form>
</div>
<div class="link" style="margin-top: 10px;">
    <a href="hapus_notifikasi.php" 
       style="display: block; padding: 10px; background: #95a5a6; color: white; border-radius: 5px; text-decoration: none;">
       HAPUS NOTIFIKASI & BATAL
    </a>
</div>