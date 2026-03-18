<?php
include 'koneksi.php';

$email = $_POST['email'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

if(mysqli_num_rows($query) > 0) {
    $user = mysqli_fetch_assoc($query);
    
    $token = md5(time());
    $expire = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    mysqli_query($conn, "UPDATE users SET reset_token = '$token', reset_expire = '$expire' WHERE id = " . $user['id']);
    
    $link = "http://localhost/db_toko_fashion/reset_password.php?token=$token";
    
    echo "
    <script>
    alert('Link Reset: $link');
    window.location.href = 'lupa_password.php?success=1';
    </script>
    ";
} else {
    header("Location: lupa_password.php?error=1");
}
?>