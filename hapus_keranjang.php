<?php
session_start();

$id = $_GET['id'];
$act = $_GET['act'];

if(isset($_SESSION['keranjang'][$id])) {
    if($act == 'tambah') {
        $_SESSION['keranjang'][$id]['qty']++;
    } elseif($act == 'kurang') {
        $_SESSION['keranjang'][$id]['qty']--;
        if($_SESSION['keranjang'][$id]['qty'] == 0) {
            unset($_SESSION['keranjang'][$id]);
        }
    }
}

header("Location: keranjang.php");
?>